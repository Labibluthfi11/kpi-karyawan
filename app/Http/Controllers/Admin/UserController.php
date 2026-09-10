<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['department', 'role'])
            ->whereHas('role', function ($query) {
                $query->where('name', '!=', 'Admin');
            })
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::whereIn('name', ['Leader', 'Anggota'])->get();
        // Filter: Hanya ambil user yang role-nya Leader atau Supervisor
        $potentialSupervisors = User::whereHas('role', function ($query) {
            $query->whereIn('name', ['Leader', 'Supervisor']);
        })->get();
        return view('admin.users.create', compact('departments', 'roles', 'potentialSupervisors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            'role_id' => 'required|exists:roles,id',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        // Generate unique 4-digit PIN
        $pin = rand(1000, 9999);
        while (User::where('pin', $pin)->exists()) {
            $pin = rand(1000, 9999);
        }

        User::create([
            'name' => $request->name,
            'email' => 'user_' . Str::random(8) . '_' . time() . '@kpi.com',
            'password' => Hash::make('password123'),
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'supervisor_id' => $request->supervisor_id,
            'pin' => $pin,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Karyawan berhasil ditambahkan dengan PIN: ' . $pin);
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        $roles = Role::whereIn('name', ['Leader', 'Anggota'])->get();
        // Filter: Hanya ambil user yang role-nya Leader atau Supervisor dan bukan dirinya sendiri
        $potentialSupervisors = User::where('id', '!=', $user->id)
            ->whereHas('role', function ($query) {
                $query->whereIn('name', ['Leader', 'Supervisor']);
            })->get();
        return view('admin.users.edit', compact('user', 'departments', 'roles', 'potentialSupervisors'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            'role_id' => 'required',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $userData = [
            'name' => $request->name,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'supervisor_id' => $request->supervisor_id,
        ];

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'Karyawan berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if ($user->role->name === 'Admin') {
            return redirect()->route('admin.users.index')->with('error', 'Akun Admin tidak bisa dihapus!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Karyawan berhasil dihapus');
    }

    public function results()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', '!=', 'Admin');
        })
        ->with('department')
        ->get()
        ->groupBy(function($user) {
            return $user->department ? $user->department->name : 'Tanpa Divisi';
        });

        return view('admin.results.index', compact('users'));
    }

    public function userResults(User $user)
    {
        $assessments = \App\Models\KpiAssessment::where('evaluatee_id', $user->id)
            ->with(['evaluator', 'results.question'])
            ->latest()
            ->get();
            
        return view('admin.results.show', compact('user', 'assessments'));
    }
}
