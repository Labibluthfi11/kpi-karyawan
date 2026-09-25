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
            ->get()
            ->groupBy(function($user) {
                return $user->department ? $user->department->name : 'Tanpa Divisi';
            });
            
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::whereIn('name', [\App\Models\User::ROLE_LEADER, \App\Models\User::ROLE_ANGGOTA])->get();
        // Filter: Hanya ambil user yang role-nya Leader atau Supervisor
        $potentialSupervisors = User::whereHas('role', function ($query) {
            $query->whereIn('name', [\App\Models\User::ROLE_LEADER, \App\Models\User::ROLE_SUPERVISOR]);
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
        $roles = Role::whereIn('name', [\App\Models\User::ROLE_LEADER, \App\Models\User::ROLE_ANGGOTA])->get();
        // Filter: Hanya ambil user yang role-nya Leader atau Supervisor dan bukan dirinya sendiri
        $potentialSupervisors = User::where('id', '!=', $user->id)
            ->whereHas('role', function ($query) {
                $query->whereIn('name', [\App\Models\User::ROLE_LEADER, \App\Models\User::ROLE_SUPERVISOR]);
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

        // Hapus data terkait sebelum menghapus user
        $user->assessmentsReceived()->each(function ($assessment) {
            $assessment->results()->delete();
            $assessment->delete();
        });
        
        $user->assignments()->delete(); 

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Selamat anda berhasil menghapus karyawan bangsat nanbiadap serta pukimak ini');
    }

    public function results(Request $request)
    {
        $activePeriod = \App\Models\AssessmentPeriod::where('is_active', true)->first();
        $periodId = $request->query('period_id', $activePeriod ? $activePeriod->id : null);
        $periods = \App\Models\AssessmentPeriod::all();

        $departments = \App\Models\Department::with(['users' => function($q) {
            $q->whereHas('role', function ($qr) {
                $qr->where('name', '!=', 'Admin');
            });
        }, 'users.assessmentsReceived' => function($q) use ($periodId) {
            $q->where('period_id', $periodId);
        }, 'users.assessmentsReceived.results'])
        ->get();

        $processedDepartments = $departments->map(function ($dept) {
            $deptUsers = $dept->users->map(function ($user) {
                $scores = $user->assessmentsReceived->flatMap->results->pluck('score');
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avg' => $scores->avg() ? (float)number_format($scores->avg(), 2) : 0
                ];
            })->sortByDesc('avg');

            return [
                'name' => $dept->name,
                'user_count' => $deptUsers->count(),
                'avg' => $deptUsers->avg('avg') ? number_format($deptUsers->avg('avg'), 2) : 0,
                'users' => $deptUsers
            ];
        });

        return view('admin.results.index', compact('processedDepartments', 'periods', 'periodId'));
    }

    public function userResults(Request $request, User $user)
    {
        $periodId = $request->query('period_id');
        
        // Jika tidak ada period_id di URL, ambil periode aktif
        if (!$periodId) {
            $activePeriod = \App\Models\AssessmentPeriod::where('is_active', true)->first();
            $periodId = $activePeriod ? $activePeriod->id : null;
        }

        $assessments = \App\Models\KpiAssessment::where('evaluatee_id', $user->id)
            ->where('period_id', $periodId)
            ->with(['evaluator', 'results.question'])
            ->latest()
            ->get();
            
        return view('admin.results.show', compact('user', 'assessments'));
    }
}
