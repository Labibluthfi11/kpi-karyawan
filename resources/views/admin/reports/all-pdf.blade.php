<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi KPI</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #16302E; font-size: 12px; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #16302E; padding-bottom: 10px; }
        .header h1 { font-size: 18px; margin: 0 0 5px; color: #16302E; }
        .header p { font-size: 12px; margin: 0; color: #5B6B68; }
        .section-title { font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; color: #16302E; background: #F1F6F5; padding: 6px 10px; border-left: 4px solid #75B8C0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #d1d5db; padding: 8px 10px; text-align: left; }
        th { background-color: #F1F6F5; color: #16302E; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge { display: inline-block; padding: 2px 6px; font-size: 10px; font-weight: bold; border-radius: 4px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #5B6B68; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN REKAPITULASI KINERJA KARYAWAN (KPI)</h1>
        <p>Periode: {{ $period ? $period->name : 'Semua Periode' }} | Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>

    @foreach($processedDepartments as $dept)
        <div class="section-title">{{ $dept['name'] }} (Total Karyawan: {{ $dept['user_count'] }} | Rata-Rata Divisi: {{ $dept['avg'] }})</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Karyawan</th>
                    <th style="width: 20%;" class="text-center">Rata-Rata Skor (0-5)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dept['users'] as $index => $user)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td class="text-center font-bold" style="color: {{ $user['avg'] >= 4 ? '#2F5B1F' : ($user['avg'] >= 3 ? '#16302E' : '#D97757') }};">
                            {{ $user['avg'] }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center" style="color: #5B6B68;">Tidak ada karyawan di departemen ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

    <div class="footer">
        <p>Sistem Penilaian Kinerja Karyawan (KPI) - Dokumen Resmi</p>
    </div>
</body>
</html>
