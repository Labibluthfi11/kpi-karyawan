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
    public function index(\Illuminate\Http\Request $request)
    {
        $periodId = $request->query('period_id');
        
        $activePeriod = AssessmentPeriod::where('is_active', true)->first();
        
        if (!$periodId && $activePeriod) {
            $periodId = $activePeriod->id;
        }

        $periods = AssessmentPeriod::all();
        $currentPeriod = AssessmentPeriod::find($periodId);
        
        // Cari periode sebelumnya (berdasarkan ID yang lebih kecil atau tanggal)
        $previousPeriod = AssessmentPeriod::where('id', '<', $periodId)->orderBy('id', 'desc')->first();

        // Data Chart: Rata-rata nilai per periode (tetap global untuk tren)
        $chartData = AssessmentPeriod::all()->mapWithKeys(function ($period) {
            $avg = KpiResult::whereHas('assessment', function($q) use ($period) {
                $q->where('period_id', $period->id);
            })->avg('score');
            return [$period->name => $avg ? (float)number_format($avg, 2) : 0];
        });

        $stats = [
            'users' => User::whereHas('role', function ($query) {
                $query->where('name', '!=', User::ROLE_ADMIN);
            })->count(),
            'assignments' => $periodId ? AssessmentAssignment::where('period_id', $periodId)->count() : 0,
            'assessments' => $periodId ? KpiAssessment::where('period_id', $periodId)->count() : 0,
        ];

        // Helper untuk ambil rata-rata per dept/kategori
        $getAnalytics = function($modelClass, $relation, $pId) {
            return $modelClass::with(["users.$relation" => function($q) use ($pId) {
                $q->where('period_id', $pId);
            }, "users.$relation.results"])
            ->get()
            ->map(function ($item) use ($relation) {
                $scores = $item->users->flatMap->$relation->flatMap->results->pluck('score');
                return [
                    'name' => $item->name,
                    'avg' => $scores->avg() ? (float)number_format($scores->avg(), 2) : 0
                ];
            });
        };

        // Analitik Departemen
        $deptData = $getAnalytics(\App\Models\Department::class, 'assessmentsReceived', $periodId);
        $prevDeptData = $previousPeriod ? $getAnalytics(\App\Models\Department::class, 'assessmentsReceived', $previousPeriod->id) : collect();

        $deptAnalytics = $deptData->map(function($dept) use ($prevDeptData) {
            $prev = $prevDeptData->firstWhere('name', $dept['name']);
            return array_merge($dept, ['trend' => $prev ? $dept['avg'] - $prev['avg'] : 0]);
        })->sortByDesc('avg')->values();

        // Analitik Kategori
        $getCategoryAnalytics = function($pId) {
            return \App\Models\KpiQuestion::select('category')
                ->distinct()
                ->get()
                ->map(function ($q) use ($pId) {
                    $avg = \App\Models\KpiResult::whereHas('assessment', function($query) use ($pId) {
                        $query->where('period_id', $pId);
                    })->whereHas('question', function($query) use ($q) {
                        $query->where('category', $q->category);
                    })->avg('score');
                    return ['name' => $q->category, 'avg' => $avg ? (float)number_format($avg, 2) : 0];
                });
        };

        $catData = $getCategoryAnalytics($periodId);
        $prevCatData = $previousPeriod ? $getCategoryAnalytics($previousPeriod->id) : collect();

        $categoryAnalytics = $catData->map(function($cat) use ($prevCatData) {
            $prev = $prevCatData->firstWhere('name', $cat['name']);
            return array_merge($cat, ['trend' => $prev ? $cat['avg'] - $prev['avg'] : 0]);
        })->sortByDesc('avg')->values();

        // Top/Bottom Performers (berdasarkan periode aktif)
        $performers = User::whereHas('role', function ($q) { $q->where('name', '!=', 'Admin'); })
            ->whereHas('assessmentsReceived', function($q) use ($periodId) {
                $q->where('period_id', $periodId);
            })
            ->with(['department', 'assessmentsReceived.results' => function($q) use ($periodId) {
                $q->whereHas('assessment', function($q) use ($periodId) {
                    $q->where('period_id', $periodId);
                });
            }])
            ->get()
            ->map(function($user) {
                $scores = $user->assessmentsReceived->flatMap->results->pluck('score');
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'group' => $user->department?->group ?? 'unknown',
                    'avg_score' => (float)$scores->avg(),
                    'count' => $scores->count()
                ];
            })
            ->filter(function($user) {
                return $user['count'] >= 1; // Threshold: minimal 1 penilaian
            })
            ->sortByDesc('avg_score');

        $manufacturingRankings = $performers->where('group', 'manufacturing');
        $officeRankings = $performers->where('group', 'office');

        $topManufacturing = $manufacturingRankings->take(5);
        $bottomManufacturing = $manufacturingRankings->reject(function ($value) use ($topManufacturing) {
            return $topManufacturing->contains('id', $value['id']);
        })->sortBy('avg_score')->take(5);

        $topOffice = $officeRankings->take(5);
        $bottomOffice = $officeRankings->reject(function ($value) use ($topOffice) {
            return $topOffice->contains('id', $value['id']);
        })->sortBy('avg_score')->take(5);

        return view('admin.dashboard', compact('stats', 'chartData', 'topManufacturing', 'bottomManufacturing', 'topOffice', 'bottomOffice', 'deptAnalytics', 'categoryAnalytics', 'periods', 'periodId', 'performers'));
    }
}
