<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Target | KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function redirectToAssessment(select) {
            if (select.value) {
                window.location.href = select.value;
            }
        }
    </script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-sm w-full text-center">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($targetUsers->count() > 0)
            <h1 class="text-2xl font-semibold text-slate-900 mb-8 tracking-tight">Siapa yang ingin dinilai?</h1>
            <div class="space-y-3">
                @foreach($targetUsers as $target)
                    @if($target->is_assessed)
                        <div class="w-full p-4 text-lg border border-green-200 rounded-xl bg-green-50 text-green-700 flex justify-between items-center cursor-not-allowed">
                            <span>{{ $target->name }}</span>
                            <span class="text-sm font-semibold">✓ Selesai</span>
                        </div>
                    @else
                        <a href="{{ route('kpi.form', $target) }}" class="block w-full p-4 text-lg border border-slate-300 rounded-xl hover:border-blue-500 hover:ring-2 hover:ring-blue-500 bg-white text-slate-700 transition-all text-left">
                            {{ $target->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <h1 class="text-2xl font-semibold text-slate-900 mb-8 tracking-tight">Semua sudah selesai dinilai!</h1>
            <p class="text-slate-500 mb-8">Terima kasih atas penilaian Anda.</p>
            <a href="/" class="block w-full p-4 text-lg bg-black text-white rounded-xl hover:bg-slate-800 transition-all">
                Selesai
            </a>
        @endif

        <div class="pt-8">
            <a href="{{ route('kiosk.department') }}" class="text-sm text-slate-400 hover:text-slate-600">Kembali ke awal</a>
        </div>
    </div>
</body>
</html>