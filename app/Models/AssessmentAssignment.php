<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentAssignment extends Model
{
    use HasFactory, Loggable;

    protected $fillable = ['evaluator_id', 'evaluatee_id', 'type', 'status', 'period_id'];

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function evaluatee()
    {
        return $this->belongsTo(User::class, 'evaluatee_id');
    }

    public function period()
    {
        return $this->belongsTo(AssessmentPeriod::class, 'period_id');
    }

    public static function generate()
    {
        $currentPeriod = \App\Models\AssessmentPeriod::where('is_active', true)->first();
        if (!$currentPeriod) return;
        
        $users = User::with(['role', 'department'])->get();
        $leaders = $users->where('role.name', \App\Models\User::ROLE_LEADER);
        $supervisors = $users->where('role.name', \App\Models\User::ROLE_SUPERVISOR);

        $safeCreate = function($evaluatorId, $evaluateeId, $type) use ($currentPeriod) {
            if ($evaluatorId == $evaluateeId) return;
            
            self::updateOrCreate([
                'evaluator_id' => $evaluatorId,
                'evaluatee_id' => $evaluateeId,
                'period_id' => $currentPeriod->id,
            ], [
                'type' => $type,
                'status' => 'pending',
            ]);
        };

        // 1. Atasan - Bawahan
        foreach ($users as $user) {
            if ($user->role?->name == 'Manager' || $user->department?->name == 'Manager') continue;
            if ($user->supervisor_id) {
                $safeCreate($user->supervisor_id, $user->id, 'leader_to_team');
                $supervisor = $users->firstWhere('id', $user->supervisor_id);
                if ($supervisor && $supervisor->department?->name != 'Manager') {
                    $safeCreate($user->id, $user->supervisor_id, 'team_to_leader');
                }
            }
        }

        // 2. Antar Leader (Strict 1-to-1)
        $filteredLeaders = $leaders->filter(function ($leader) {
            return !in_array($leader->department?->name, ['Manager', 'Supervisor']);
        });

        $leaderGroups = [
            'manufacturing' => $filteredLeaders->where('department.group', 'manufacturing'),
            'office' => $filteredLeaders->where('department.group', 'office')
        ];

        foreach ($leaderGroups as $group => $groupedLeaders) {
            $leadersArray = $groupedLeaders->values();
            $count = $groupedLeaders->count();
            if ($count < 2) continue;

            // Pastikan setiap leader hanya punya 1 target penilaian
            // Menggunakan pergeseran tetap agar tidak dobel dalam satu periode
            for ($i = 0; $i < $count; $i++) {
                $targetIndex = ($i + 1) % $count;
                $safeCreate($leadersArray[$i]->id, $leadersArray[$targetIndex]->id, 'leader_to_leader');
            }
        }

        // 3. Supervisor dinilai Leader Produksi
        $manufacturingLeaders = $leaders->where('department.group', 'manufacturing');
        $manufacturingSupervisors = $supervisors->where('department.group', 'manufacturing');
        
        foreach ($manufacturingSupervisors as $supervisor) {
            foreach ($manufacturingLeaders as $leader) {
                $safeCreate($leader->id, $supervisor->id, 'team_to_leader');
            }
        }
    }
}
