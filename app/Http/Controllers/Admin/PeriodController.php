<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentPeriod;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = AssessmentPeriod::orderBy('start_date', 'desc')->get();
        return view('admin.periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($request->has('is_active')) {
            AssessmentPeriod::where('is_active', true)->update(['is_active' => false]);
        }

        AssessmentPeriod::create([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil ditambahkan');
    }

    public function edit(AssessmentPeriod $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    public function update(Request $request, AssessmentPeriod $period)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($request->has('is_active') && !$period->is_active) {
            AssessmentPeriod::where('is_active', true)->update(['is_active' => false]);
        }

        $period->update([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil diupdate');
    }

    public function destroy(AssessmentPeriod $period)
    {
        $period->delete();
        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil dihapus');
    }
}
