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
    public function form(User $user)
    {
        // 1. Ambil periode aktif
        $activePeriod = \App\Models\AssessmentPeriod::where('is_active', true)->first();
        if (!$activePeriod) {
            return redirect()->route('kpi.no-period')->with('error', 'Tidak ada periode penilaian aktif saat ini.');
        }

        // 2. Prioritaskan sesi kiosk, jika tidak ada baru gunakan Auth::user()
        $evaluatorId = session('kiosk_user_id', Auth::id());
        $evaluator = \App\Models\User::find($evaluatorId);
        
        // 3. Cek apakah sudah ada penilaian FINAL (completed) untuk PERIODE INI
        $isCompleted = KpiAssessment::where('evaluator_id', $evaluatorId)
            ->where('evaluatee_id', $user->id)
            ->where('period_id', $activePeriod->id) // Filter berdasarkan periode aktif
            ->where('status', 'completed')
            ->exists();

        // Kalau sudah selesai di periode ini, baru kita blokir.
        if ($isCompleted) {
            return redirect()->route('kiosk.assessment')->with('error', 'Anda sudah melakukan penilaian final untuk karyawan ini pada periode ini.');
        }
        
        // Ambil penugasan berdasarkan evaluator dan target
        $assignment = \App\Models\AssessmentAssignment::where('evaluator_id', $evaluator->id)
            ->where('evaluatee_id', $user->id)
            ->first();

        // Gunakan type dari assignment, default ke leader_to_team jika tidak ditemukan
        $type = $assignment ? $assignment->type : 'leader_to_team';
        
        $questions = KpiQuestion::where('type', $type)->get();
        
        // Cek apakah sudah ada penilaian (draft) pada PERIODE INI
        $existingAssessment = KpiAssessment::where('evaluator_id', $evaluatorId)
            ->where('evaluatee_id', $user->id)
            ->where('period_id', $activePeriod->id)
            ->first();
        
        $existingScores = [];
        $existingNotes = [];
        if ($existingAssessment) {
            $existingScores = KpiResult::where('assessment_id', $existingAssessment->id)
                ->pluck('score', 'question_id')
                ->toArray();
            $existingNotes = KpiResult::where('assessment_id', $existingAssessment->id)
                ->pluck('note', 'question_id')
                ->toArray();
        }
        
        return view('kpi.form', compact('user', 'questions', 'existingScores', 'existingNotes'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500',
            'general_note' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,completed'
        ]);

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $user) {
            // Cek apakah ada periode aktif
            $activePeriod = \App\Models\AssessmentPeriod::where('is_active', true)->first();
            if (!$activePeriod) {
                return redirect()->route('kpi.no-period')->with('error', 'Tidak ada periode penilaian aktif saat ini.');
            }

            $evaluatorId = session('kiosk_user_id', Auth::id());
            
            // Cari apakah sudah ada penilaian (draft atau completed) pada periode ini
            $existingAssessment = KpiAssessment::where('evaluator_id', $evaluatorId)
                ->where('evaluatee_id', $user->id)
                ->where('period_id', $activePeriod->id)
                ->first();

            // Jika sudah ada dan statusnya completed, tidak bisa diubah
            if ($existingAssessment && $existingAssessment->status === 'completed') {
                return redirect()->route('kiosk.assessment')->with('error', 'Anda sudah melakukan penilaian final untuk karyawan ini pada periode ini.');
            }

            if ($existingAssessment) {
                // Update penilaian yang sudah ada (draft)
                $existingAssessment->update([
                    'status' => $request->status,
                    'general_note' => $request->general_note,
                ]);

                // Hapus hasil lama dan buat yang baru
                \App\Models\KpiResult::where('assessment_id', $existingAssessment->id)->delete();
                $assessmentId = $existingAssessment->id;
            } else {
                // Buat penilaian baru
                $assessment = KpiAssessment::create([
                    'evaluator_id' => $evaluatorId,
                    'evaluatee_id' => $user->id,
                    'assessment_date' => now(),
                    'period_id' => $activePeriod->id,
                    'status' => $request->status,
                    'general_note' => $request->general_note,
                ]);
                $assessmentId = $assessment->id;
            }

            foreach ($request->scores as $questionId => $score) {
                KpiResult::create([
                    'assessment_id' => $assessmentId,
                    'question_id' => $questionId,
                    'score' => $score,
                    'note' => $request->notes[$questionId] ?? null,
                ]);
            }

            // Update status assignment menjadi completed hanya jika statusnya completed
            if ($request->status === 'completed') {
                \App\Models\AssessmentAssignment::where('evaluator_id', $evaluatorId)
                    ->where('evaluatee_id', $user->id)
                    ->update(['status' => 'completed']);
            }

            $msg = $request->status === 'draft' ? 'Draft penilaian tersimpan.' : 'Penilaian tersimpan.';
            return redirect()->route('kiosk.assessment')->with('success', $msg);
        });
    }
}
