<?php

namespace App\Exports;

use App\Models\User;
use App\Models\KpiAssessment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KpiUserExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $user;
    protected $periodId;

    public function __construct(User $user, $periodId)
    {
        $this->user = $user;
        $this->periodId = $periodId;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $assessments = KpiAssessment::where('evaluatee_id', $this->user->id)
            ->where('period_id', $this->periodId)
            ->with(['evaluator', 'results.question'])
            ->get();

        $rows = collect();

        foreach ($assessments as $assessment) {
            foreach ($assessment->results as $result) {
                $rows->push([
                    'evaluator' => $assessment->evaluator?->name ?? 'Unknown',
                    'category' => $result->question?->category ?? '-',
                    'question' => $result->question?->question_text ?? '-',
                    'score' => $result->score,
                    'note' => $result->note ?? '-',
                    'general_note' => $assessment->general_note ?? '-',
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Penilai (Evaluator)',
            'Kategori',
            'Pertanyaan',
            'Skor (1-5)',
            'Catatan per Soal',
            'Catatan Umum'
        ];
    }

    public function map($row): array
    {
        return [
            $row['evaluator'],
            $row['category'],
            $row['question'],
            $row['score'],
            $row['note'],
            $row['general_note'],
        ];
    }
}
