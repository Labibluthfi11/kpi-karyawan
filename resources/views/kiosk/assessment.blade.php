<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Target | Kiosk KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');</style>
</head>
<body class="min-h-screen p-6" style="background:#EEF2F1;">
    <div class="max-w-md mx-auto w-full">
        @if(session('success'))
            <div class="bg-green-100 border-2 border-green-500 text-green-700 px-4 py-3 rounded-xl mb-6 font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-2 border-red-500 text-red-700 px-4 py-3 rounded-xl mb-6 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-2xl border-2 mb-8" style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;">
            @if($targetUsers->count() > 0)
                <h1 class="text-2xl font-bold mb-6 text-center" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Siapa yang ingin dinilai?</h1>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($targetUsers as $target)
                        @php
                            // Ambil periode aktif
                            $activePeriod = \App\Models\AssessmentPeriod::where('is_active', true)->first();
                            
                            // Cek status penilaian untuk periode aktif
                            $isCompleted = false;
                            if ($activePeriod) {
                                $isCompleted = \App\Models\KpiAssessment::where('evaluator_id', session('kiosk_user_id'))
                                    ->where('evaluatee_id', $target->id)
                                    ->where('period_id', $activePeriod->id)
                                    ->where('status', 'completed')
                                    ->exists();
                            }
                        @endphp
                        
                        @if($isCompleted)
                            <div class="block p-4 text-md font-semibold rounded-xl border-2 opacity-60 cursor-not-allowed"
                                 style="border-color:#5B6B68; background:#EEF2F1; color:#5B6B68;">
                                <div class="flex justify-between items-center">
                                    {{ $target->name }}
                                    <span class="text-xs font-bold uppercase bg-[#E8F4E0] text-[#2F5B1F] px-2 py-0.5 rounded-full">Selesai</span>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('kpi.form', $target) }}" 
                               class="block p-4 text-md font-semibold rounded-xl border-2 transition-all hover:-translate-y-0.5"
                               style="border-color:#16302E; background:#FFFFFF; color:#16302E; box-shadow:3px 3px 0px 0px #75B8C0;">
                                <div class="flex justify-between items-center">
                                    {{ $target->name }}
                                    <span class="text-xs font-bold uppercase bg-[#FDF3E7] text-[#E08E4E] px-2 py-0.5 rounded-full">Pending</span>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <h1 class="text-2xl font-bold mb-4 text-center" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Selesai!</h1>
                <p class="text-center mb-8" style="color:#5B6B68;">Semua penilaian sudah diinput.</p>
                <a href="{{ route('kiosk.department') }}" 
                   class="block w-full p-4 text-lg font-bold text-center rounded-xl border-2 text-white transition-all"
                   style="background:#16302E; border-color:#16302E; box-shadow:3px 3px 0px 0px #F4A261;">
                    Kembali ke Awal
                </a>
            @endif
        </div>
        <div class="text-center flex flex-col gap-4">
            <a href="{{ route('kiosk.department') }}" class="text-sm font-medium" style="color:#5B6B68;">← Kembali</a>
            
            <form action="{{ route('kiosk.logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="font-medium py-2 px-5 rounded-lg border-2 transition-all hover:bg-red-50"
                        style="border-color:#16302E; color:#16302E;">
                    Logout Sesi
                </button>
            </form>
        </div>
    </div>
</body>
</html>