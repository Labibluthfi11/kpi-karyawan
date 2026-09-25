<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Divisi: {{ $department->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #16302E; font-size: 12px; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #16302E; padding-bottom: 10px; }
        .header h1 { font-size: 18px; margin: 0 0 5px; color: #16302E; }
        .header p { font-size: 12px; margin: 0; color: #5B6B68; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #d1d5db; padding: 8px 10px; text-align: left; }
        th { background-color: #F1F6F5; color: #16302E; font-weight: bold; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #5B6B68; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KINERJA DIVISI: {{ strtoupper($department->name) }}</h1>
        <p>Periode: {{ $period ? $period->name : 'Semua Periode' }} | Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th>Nama Karyawan</th>
                <th style="width: 15%;" class="text-center">PIN</th>
                <th style="width: 20%;" class="text-center">Rata-Rata Skor</th>
                <th style="width: 20%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                @php
                    $scores = $user->assessmentsReceived->flatMap->results->pluck('score');
                    $avg = $scores->avg() ? number_format($scores->avg(), 2) : '0.00';
                    $status = $user->assessmentsReceived->count() > 0 ? 'Sudah Dinilai' : 'Belum Dinilai';
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td class="text-center">{{ $user->pin }}</td>
                    <td class="text-center font-bold" style="color: {{ $avg >= 4 ? '#2F5B1F' : ($avg >= 3 ? '#16302E' : '#D97757') }};">{{ $avg }}</td>
                    <td class="text-center">{{ $status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #5B6B68;">Belum ada karyawan di divisi ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Sistem Penilaian Kinerja Karyawan (KPI) - Dokumen Resmi</p>
    </div>
</body>
</html>
