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

    // 5. Tampilkan daftar orang yang harus dinilai
    public function assessment() {
        dd('KONTROLER KEPANGGIL BRO!');
        $user = User::find(session('kiosk_user_id'));
        if (!$user) return redirect()->route('kiosk.department');

        $targetUsers = [];
        // Logic filter target user yang sama dengan di KpiAssessmentController::index()
        if ($user->role->name === 'Leader') {
            $targetUsers = User::where('department_id', $user->department_id)
                               ->whereHas('role', function($query) {
                                   $query->where('name', 'Anggota');
                               })->get();
        } elseif ($user->role->name === 'Anggota') {
            $targetUsers = User::where('department_id', $user->department_id)
                               ->whereHas('role', function($query) {
                                   $query->where('name', 'Leader');
                               })->get();
        }

        return view('kiosk.assessment', compact('targetUsers'));
    }
}
