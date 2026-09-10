<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['evaluator_id', 'evaluatee_id', 'type', 'status'];

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function evaluatee()
    {
        return $this->belongsTo(User::class, 'evaluatee_id');
    }

    public static function generate()
    {
        self::truncate();
        
        $users = User::with(['role', 'department'])->get();
        
        // Pengelompokan berdasarkan Role
        $leaders = $users->where('role.name', 'Leader');
        $supervisors = $users->where('role.name', 'Supervisor');
        $managers = $users->where('role.name', 'Manager');
        
        // Pengelompokan berdasarkan Group Departemen
        $manufacturingUsers = $users->where('department.group', 'manufacturing');
        $officeUsers = $users->where('department.group', 'office');

        // 1. Atasan - Bawahan (Otomatis)
        foreach ($users as $user) {
            // Manager/User di departemen "Manager" tidak bisa dinilai (bukan evaluatee)
            if ($user->role?->name == 'Manager' || $user->department?->name == 'Manager') continue;

            if ($user->supervisor_id) {
                // Atasan menilai bawahan
                self::create([
                    'evaluator_id' => $user->supervisor_id,
                    'evaluatee_id' => $user->id,
                    'type' => 'leader_to_team',
                    'status' => 'pending'
                ]);
                // Bawahan menilai atasan (hanya jika atasan bukan di departemen "Manager")
                $supervisor = $users->firstWhere('id', $user->supervisor_id);
                if ($supervisor && $supervisor->department?->name != 'Manager') {
                    self::create([
                        'evaluator_id' => $user->id,
                        'evaluatee_id' => $user->supervisor_id,
                        'type' => 'team_to_leader',
                        'status' => 'pending'
                    ]);
                }
                }
                }


        // 2. Antar Leader (Rotasi 1-on-1 Bergilir per Periode, terisolasi per Group)
        // Mengecualikan leader yang berada di departemen "Manager" atau "Supervisor" dari rotasi
        $currentPeriod = \App\Models\AssessmentPeriod::where('is_active', true)->first();
        $periodIndex = $currentPeriod ? $currentPeriod->id : 1;

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
            if ($count < 2) continue; // Minimal 2 orang untuk rotasi

            for ($i = 0; $i < $count; $i++) {
                // Algoritma rotasi: setiap periode, geser targetnya
                $targetIndex = ($i + $periodIndex) % $count;
                if ($i == $targetIndex) $targetIndex = ($i + 1) % $count; // Hindari nilai diri sendiri

                self::create([
                    'evaluator_id' => $leadersArray[$i]->id,
                    'evaluatee_id' => $leadersArray[$targetIndex]->id,
                    'type' => 'leader_to_leader',
                    'status' => 'pending'
                ]);
            }
        }

        // 3. Supervisor dinilai Leader Produksi (Khusus Manufacturing)
        $manufacturingLeaders = $leaders->where('department.group', 'manufacturing');
        $manufacturingSupervisors = $supervisors->where('department.group', 'manufacturing');
        
        foreach ($manufacturingSupervisors as $supervisor) {
            foreach ($manufacturingLeaders as $leader) {
                self::create([
                    'evaluator_id' => $leader->id,
                    'evaluatee_id' => $supervisor->id,
                    'type' => 'team_to_leader', // Leader menilai Supervisor
                    'status' => 'pending'
                ]);
            }
        }
    }
}
