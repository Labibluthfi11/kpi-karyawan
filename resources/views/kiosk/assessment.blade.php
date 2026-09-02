<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Target | KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xs w-full text-center">
        <h1 class="text-xl font-medium text-slate-900 mb-12 tracking-tight">Siapa yang ingin dinilai?</h1>
        <div class="space-y-4">
            @forelse($targetUsers as $target)
                <a href="{{ route('kpi.form', $target) }}" class="block w-full text-slate-600 hover:text-black py-4 border-b border-slate-100 transition duration-200">
                    {{ $target->name }}
                </a>
            @empty
                <p class="text-slate-500">Tidak ada karyawan yang tersedia untuk dinilai.</p>
            @endforelse
            <div class="pt-8">
                <a href="{{ route('kiosk.department') }}" class="text-xs text-slate-400 hover:text-slate-600">Kembali ke awal</a>
            </div>
        </div>
    </div>
</body>
</html>
