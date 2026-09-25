<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor KPI: {{ $user->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #16302E; font-size: 11px; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #16302E; padding-bottom: 8px; }
        .header h1 { font-size: 16px; margin: 0 0 3px; color: #16302E; }
        .header p { font-size: 11px; margin: 0; color: #5B6B68; }
        .user-info { margin-bottom: 15px; background: #F1F6F5; padding: 10px; border-radius: 6px; }
        .user-info table { width: 100%; border: none; }
        .user-info td { border: none; padding: 2px 0; }
        .assessment-box { margin-bottom: 20px; border: 1px solid #16302E; padding: 12px; border-radius: 6px; }
        .assessment-header { font-weight: bold; font-size: 13px; margin-bottom: 8px; border-bottom: 1px solid #d1d5db; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background-color: #F1F6F5; color: #16302E; font-weight: bold; }
        .text-center { text-align: center; }
        .general-note { margin-top: 10px; background: #FFF9F5; border-left: 3px solid #F4A261; padding: 8px; font-style: italic; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #5B6B68; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RAPOR DETAIL KINERJA KARYAWAN (KPI)</h1>
        <p>Periode: {{ $period ? $period->name : 'Semua Periode' }}</p>
    </div>

    <div class="user-info">
        <table>
            <tr>
                <td style="width: 20%;"><strong>Nama Karyawan:</strong></td>
                <td>{{ $user->name }}</td>
                <td style="width: 15%;"><strong>Divisi:</strong></td>
                <td>{{ $user->department?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Peran:</strong></td>
                <td>{{ $user->role?->name ?? '-' }}</td>
                <td><strong>PIN:</strong></td>
                <td>{{ $user->pin }}</td>
            </tr>
        </table>
    </div>

    @forelse($assessments as $assessment)
        @php
            $allScores = $assessment->results->pluck('score');
            $avgScore = $allScores->avg() ? number_format($allScores->avg(), 2) : '0.00';
            $groupedResults = $assessment->results->groupBy('question.category');
        @endphp
        <div class="assessment-box">
            <div class="assessment-header">
                Dinilai Oleh: {{ $assessment->evaluator?->name ?? 'Unknown' }} 
                <span style="float: right; color: #75B8C0;">Rata-Rata: {{ $avgScore }} / 5.00</span>
            </div>

            @foreach($groupedResults as $category => $results)
                <div style="font-weight: bold; margin-top: 8px; margin-bottom: 4px; color: #16302E;">{{ $category }}</div>
                <table>
                    <thead>
                        <tr>
                            <th>Pertanyaan</th>
                            <th style="width: 15%;" class="text-center">Skor</th>
                            <th style="width: 35%;">Catatan per Soal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                <td>{{ $result->question?->question_text ?? '-' }}</td>
                                <td class="text-center font-bold">{{ $result->score }}</td>
                                <td>{{ $result->note ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach

            @if($assessment->general_note)
                <div class="general-note">
                    <strong>Catatan Umum Penilai:</strong> {{ $assessment->general_note }}
                </div>
            @endif
        </div>
    @empty
        <div class="text-center" style="padding: 30px; color: #5B6B68;">
            Belum ada penilaian untuk karyawan ini pada periode ini.
        </div>
    @endforelse

    <div class="footer">
        <p>Sistem Penilaian Kinerja Karyawan (KPI) - Dokumen Resmi</p>
    </div>
</body>
</html>
