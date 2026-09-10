<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AssessmentAssignment;
use App\Models\KpiAssessment;
use App\Models\KpiResult;
use App\Models\AssessmentPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'assignments' => AssessmentAssignment::count(),
            'assessments' => KpiAssessment::count(),
        ];

        // Data Chart: Rata-rata nilai per periode
        $chartData = AssessmentPeriod::all()->mapWithKeys(function ($period) {
            $avg = KpiResult::whereHas('assessment', function($q) use ($period) {
                $q->whereBetween('assessment_date', [$period->start_date, $period->end_date]);
            })->avg('score');
            return [$period->name => $avg ? (float)number_format($avg, 2) : 0];
        });

        // Top/Bottom Performers
        $performers = User::whereHas('role', function ($q) { $q->where('name', '!=', 'Admin'); })
            ->withCount(['assessmentsReceived as avg_score' => function($query) {
                $query->join('kpi_results', 'kpi_assessments.id', '=', 'kpi_results.assessment_id')
                      ->select(DB::raw('avg(score)'));
            }])
            ->get()
            ->sortByDesc('avg_score');

        $topPerformers = $performers->take(5);
        $bottomPerformers = $performers->where('avg_score', '>', 0)->sortBy('avg_score')->take(5);

        return view('admin.dashboard', compact('stats', 'chartData', 'topPerformers', 'bottomPerformers'));
    }
}
