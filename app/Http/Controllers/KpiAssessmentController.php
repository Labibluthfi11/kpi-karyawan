<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KpiQuestion;
use App\Models\KpiAssessment;
use App\Models\KpiResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KpiAssessmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $targetUsers = [];

        // Logic based on department and role scope
        if ($user->role->name === 'Supervisor') {
            // Supervisor usually oversees the department
            $targetUsers = User::where('department_id', $user->department_id)
                               ->where('role_id', '!=', $user->role_id)
                               ->get();
        } elseif ($user->role->name === 'Leader') {
            // Leader assesses members in the same department
            $targetUsers = User::where('department_id', $user->department_id)
                               ->whereHas('role', function($query) {
                                   $query->where('name', 'Anggota');
                               })->get();
        } elseif ($user->role->name === 'Anggota') {
            // Anggota assesses leader in the same department
            $targetUsers = User::where('department_id', $user->department_id)
                               ->whereHas('role', function($query) {
                                   $query->where('name', 'Leader');
                               })->get();
        }

        return view('kpi.index', compact('targetUsers'));
    }

    public function form(User $user)
    {
        $questions = KpiQuestion::where('target_role', $user->role->name)->get();
        return view('kpi.form', compact('user', 'questions'));
    }

    public function store(Request $request, User $user)
    {
        $assessment = KpiAssessment::create([
            'evaluator_id' => Auth::id(),
            'evaluatee_id' => $user->id,
            'assessment_date' => now(),
        ]);

        $totalScore = 0;
        $count = 0;

        foreach ($request->scores as $questionId => $score) {
            KpiResult::create([
                'assessment_id' => $assessment->id,
                'question_id' => $questionId,
                'score' => $score,
            ]);
            $totalScore += $score;
            $count++;
        }

        // Percentage Calculation
        $percentage = ($count > 0) ? ($totalScore / ($count * 5)) * 100 : 0;

        return redirect()->route('kpi.index')->with('success', 'Penilaian berhasil disimpan. Nilai: ' . round($percentage, 2) . '%');
    }
}
