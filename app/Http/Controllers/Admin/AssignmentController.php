<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\AssessmentAssignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('users')->get();
        $assignments = AssessmentAssignment::with(['evaluator', 'evaluatee'])->get();
        return view('admin.assignments.index', compact('departments', 'assignments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evaluator_id' => 'required|exists:users,id',
            'evaluatee_id' => 'required|exists:users,id',
        ]);

        AssessmentAssignment::create($request->all());

        return redirect()->route('admin.assignments.index')->with('success', 'Mapping berhasil dibuat');
    }

    public function destroy(AssessmentAssignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('admin.assignments.index')->with('success', 'Mapping berhasil dihapus');
    }

    public function refresh()
    {
        AssessmentAssignment::generate();
        return redirect()->route('admin.dashboard')->with('success', 'Penugasan berhasil diperbarui!');
    }
}
