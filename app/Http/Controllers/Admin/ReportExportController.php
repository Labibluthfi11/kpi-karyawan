<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\AssessmentPeriod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportExportController extends Controller
{
    /**
     * Helper to resolve active period if none provided.
     */
    protected function resolvePeriodId($periodId)
    {
        if ($periodId) {
            return $periodId;
        }

        $active = AssessmentPeriod::where('is_active', true)->first();
        return $active ? $active->id : AssessmentPeriod::latest()->value('id');
    }

    /**
     * 1. Export All Results to Excel
     */
    public function exportAllExcel(Request $request)
    {
        $periodId = $this->resolvePeriodId($request->query('period_id'));
        $period = AssessmentPeriod::find($periodId);
        $periodName = $period ? str_replace(' ', '_', $period->name) : 'All_Period';

        return Excel::download(
            new \App\Exports\KpiAllResultsExport($periodId), 
            "Laporan_KPI_Semua_{$periodName}.xlsx"
        );
    }

    /**
     * 1b. Export All Results to PDF
     */
    public function exportAllPdf(Request $request)
    {
        $periodId = $this->resolvePeriodId($request->query('period_id'));
        $period = AssessmentPeriod::find($periodId);

        $departments = Department::with(['users' => function($q) {
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

        $pdf = Pdf::loadView('admin.reports.all-pdf', compact('processedDepartments', 'period'));
        $periodName = $period ? str_replace(' ', '_', $period->name) : 'All_Period';

        return $pdf->download("Laporan_KPI_Semua_{$periodName}.pdf");
    }

    /**
     * 2. Export Department to Excel
     */
    public function exportDepartmentExcel(Request $request, Department $department)
    {
        $periodId = $this->resolvePeriodId($request->query('period_id'));
        $period = AssessmentPeriod::find($periodId);
        $periodName = $period ? str_replace(' ', '_', $period->name) : 'Periode';
        $deptName = str_replace(' ', '_', $department->name);

        return Excel::download(
            new \App\Exports\KpiDepartmentExport($department, $periodId), 
            "Laporan_KPI_Divisi_{$deptName}_{$periodName}.xlsx"
        );
    }

    /**
     * 2b. Export Department to PDF
     */
    public function exportDepartmentPdf(Request $request, Department $department)
    {
        $periodId = $this->resolvePeriodId($request->query('period_id'));
        $period = AssessmentPeriod::find($periodId);

        $users = $department->users()->with(['assessmentsReceived' => function($q) use ($periodId) {
            $q->where('period_id', $periodId);
        }, 'assessmentsReceived.results'])->get();

        $pdf = Pdf::loadView('admin.reports.department-pdf', compact('department', 'users', 'period'));
        $periodName = $period ? str_replace(' ', '_', $period->name) : 'Periode';
        $deptName = str_replace(' ', '_', $department->name);

        return $pdf->download("Laporan_KPI_Divisi_{$deptName}_{$periodName}.pdf");
    }

    /**
     * 3. Export User to Excel
     */
    public function exportUserExcel(Request $request, User $user)
    {
        $periodId = $this->resolvePeriodId($request->query('period_id'));
        $period = AssessmentPeriod::find($periodId);
        $periodName = $period ? str_replace(' ', '_', $period->name) : 'Periode';
        $userName = str_replace(' ', '_', $user->name);

        return Excel::download(
            new \App\Exports\KpiUserExport($user, $periodId), 
            "Laporan_KPI_Karyawan_{$userName}_{$periodName}.xlsx"
        );
    }

    /**
     * 3b. Export User to PDF
     */
    public function exportUserPdf(Request $request, User $user)
    {
        $periodId = $this->resolvePeriodId($request->query('period_id'));
        $period = AssessmentPeriod::find($periodId);

        $assessments = \App\Models\KpiAssessment::where('evaluatee_id', $user->id)
            ->where('period_id', $periodId)
            ->with(['evaluator', 'results.question'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.reports.user-pdf', compact('user', 'assessments', 'period'));
        $periodName = $period ? str_replace(' ', '_', $period->name) : 'Periode';
        $userName = str_replace(' ', '_', $user->name);

        return $pdf->download("Laporan_KPI_Karyawan_{$userName}_{$periodName}.pdf");
    }
}
