<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    // 1. Pilih Divisi
    public function selectDepartment() {
        $departments = Department::all();
        return view('kiosk.department', compact('departments'));
    }

    // 2. Pilih Nama berdasarkan Divisi
    public function selectUser(Department $department) {
        $users = $department->users;
        return view('kiosk.user', compact('department', 'users'));
    }

    // 3. Form Input PIN
    public function pinForm(User $user) {
        return view('kiosk.pin', compact('user'));
    }

    // 4. Validasi PIN & Masuk ke Sesi Penilaian
    public function verifyPin(Request $request, User $user) {
        if ($request->pin !== $user->pin) {
            return back()->withErrors(['pin' => 'PIN salah!']);
        }

        // Simpan ID user di session
        session(['kiosk_user_id' => $user->id]);

        return redirect()->route('kiosk.assessment');
    }

    // 4b. Log Out Kiosk
    public function logout() {
        session()->forget('kiosk_user_id');
        return redirect()->route('kiosk.department')->with('success', 'Anda telah keluar dari sesi.');
    }

    // 5. Tampilkan daftar orang yang harus dinilai
    public function assessment() {
        $user = User::find(session('kiosk_user_id'));
        if (!$user) return redirect()->route('kiosk.department');

        // Mengambil daftar karyawan yang harus dinilai oleh user ini (berdasarkan mapping)
        $targetUsers = \App\Models\AssessmentAssignment::where('evaluator_id', $user->id)
            ->with('evaluatee')
            ->get()
            ->pluck('evaluatee')
            ->unique('id');

        return view('kiosk.assessment', compact('targetUsers'));
    }
}
