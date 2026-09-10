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
        // Cek apakah ada periode aktif
        $activePeriod = \App\Models\AssessmentPeriod::where('is_active', true)->exists();
        if (!$activePeriod) {
            return redirect()->route('kpi.no-period')->with('error', 'Tidak ada periode penilaian aktif saat ini.');
        }

        // Prioritaskan sesi kiosk, jika tidak ada baru gunakan Auth::user()
        $evaluatorId = session('kiosk_user_id', Auth::id());
        $evaluator = \App\Models\User::find($evaluatorId);
        
        // Ambil penugasan berdasarkan evaluator dan target
        $assignment = \App\Models\AssessmentAssignment::where('evaluator_id', $evaluator->id)
            ->where('evaluatee_id', $user->id)
            ->first();

        // Gunakan type dari assignment, default ke leader_to_team jika tidak ditemukan
        $type = $assignment ? $assignment->type : 'leader_to_team';
        
        $questions = KpiQuestion::where('type', $type)->get();
        
        return view('kpi.form', compact('user', 'questions'));
    }

    public function store(Request $request, User $user)
    {
        // Cek apakah ada periode aktif
        $activePeriod = \App\Models\AssessmentPeriod::where('is_active', true)->exists();
        if (!$activePeriod) {
            return redirect()->route('kpi.no-period')->with('error', 'Tidak ada periode penilaian aktif saat ini.');
        }

        $evaluatorId = session('kiosk_user_id', Auth::id());
        
        // Pengecekan duplikat: apakah sudah dinilai hari ini?
        $exists = KpiAssessment::where('evaluator_id', $evaluatorId)
            ->where('evaluatee_id', $user->id)
            ->whereDate('assessment_date', now()->toDateString())
            ->exists();

        if ($exists) {
            // Jika sudah ada, arahkan kembali dengan pesan error
            if (Auth::check()) {
                return redirect()->route('kiosk.assessment')->with('error', 'Anda sudah melakukan penilaian untuk karyawan ini hari ini.');
            }
            return redirect()->route('kiosk.assessment')->with('error', 'Anda sudah melakukan penilaian untuk karyawan ini hari ini.');
        }

        $assessment = KpiAssessment::create([
            'evaluator_id' => $evaluatorId,
            'evaluatee_id' => $user->id,
            'assessment_date' => now(),
        ]);

        foreach ($request->scores as $questionId => $score) {
            KpiResult::create([
                'assessment_id' => $assessment->id,
                'question_id' => $questionId,
                'score' => $score,
            ]);
        }

        // Update status assignment menjadi completed
        \App\Models\AssessmentAssignment::where('evaluator_id', $evaluatorId)
            ->where('evaluatee_id', $user->id)
            ->update(['status' => 'completed']);

        // Jika berada dalam sesi kiosk, selalu arahkan ke halaman penilaian kiosk
        if (session()->has('kiosk_user_id')) {
            return redirect()->route('kiosk.assessment')->with('success', 'Penilaian tersimpan.');
        }

        // Jika user login (bukan kiosk), arahkan ke dashboard penugasan
        if (Auth::check()) {
            return redirect()->route('kiosk.assessment')->with('success', 'Penilaian berhasil disimpan.');
        }

        return redirect()->route('kiosk.assessment')->with('success', 'Penilaian tersimpan.');
    }
}
