<?php

namespace App\Exports;

use App\Models\Department;
use App\Models\AssessmentPeriod;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KpiAllResultsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $periodId;

    public function __construct($periodId)
    {
        $this->periodId = $periodId;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $departments = Department::with(['users' => function($q) {
            $q->whereHas('role', function ($qr) {
                $qr->where('name', '!=', 'Admin');
            });
        }, 'users.assessmentsReceived' => function($q) {
            $q->where('period_id', $this->periodId);
        }, 'users.assessmentsReceived.results'])
        ->get();

        $rows = collect();

        foreach ($departments as $dept) {
            foreach ($dept->users as $user) {
                $scores = $user->assessmentsReceived->flatMap->results->pluck('score');
                $avg = $scores->avg() ? (float)number_format($scores->avg(), 2) : 0;
                $status = $user->assessmentsReceived->count() > 0 ? 'Sudah Dinilai' : 'Belum Dinilai';

                $rows->push([
                    'department' => $dept->name,
                    'name' => $user->name,
                    'role' => $user->role?->name ?? '-',
                    'avg' => $avg,
                    'status' => $status,
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Departemen',
            'Nama Karyawan',
            'Peran',
            'Rata-Rata Skor KPI',
            'Status'
        ];
    }

    public function map($row): array
    {
        return [
            $row['department'],
            $row['name'],
            $row['role'],
            $row['avg'],
            $row['status'],
        ];
    }
}
