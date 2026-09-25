<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KpiDepartmentExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $department;
    protected $periodId;

    public function __construct(Department $department, $periodId)
    {
        $this->department = $department;
        $this->periodId = $periodId;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $users = $this->department->users()->with(['assessmentsReceived' => function($q) {
            $q->where('period_id', $this->periodId);
        }, 'assessmentsReceived.results'])->get();

        $rows = collect();

        foreach ($users as $user) {
            $scores = $user->assessmentsReceived->flatMap->results->pluck('score');
            $avg = $scores->avg() ? (float)number_format($scores->avg(), 2) : 0;
            $status = $user->assessmentsReceived->count() > 0 ? 'Sudah Dinilai' : 'Belum Dinilai';

            $rows->push([
                'name' => $user->name,
                'role' => $user->role?->name ?? '-',
                'pin' => $user->pin,
                'avg' => $avg,
                'status' => $status,
            ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Peran',
            'PIN',
            'Rata-Rata Skor KPI',
            'Status'
        ];
    }

    public function map($row): array
    {
        return [
            $row['name'],
            $row['role'],
            $row['pin'],
            $row['avg'],
            $row['status'],
        ];
    }
}
