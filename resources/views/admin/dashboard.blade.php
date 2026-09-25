<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            {{ __('Dashboard HRD - Monitoring KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Periode -->
            <div class="mb-6">
                <form id="periodForm" class="flex gap-3 items-center">
                    <label class="font-semibold text-[#16302E]">Periode:</label>
                    <select name="period_id" id="periodSelect" class="border-2 rounded-lg px-3 py-2 focus:ring-0 focus:border-[#75B8C0]" style="border-color:#16302E;">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ $periodId == $period->id ? 'selected' : '' }}>
                                {{ $period->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @include('admin.partials.top-performers')

            @if(session('success'))
                <div class="px-4 py-3 rounded-lg mb-6 text-sm font-medium" style="background:#E8F4E0; color:#2F5B1F; border:2px solid #2F5B1F;">
                    {{ session('success') }}
                </div>
            @endif
...
            <!-- Ringkasan Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-xl p-6 border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-sm text-[#5B6B68]">Total Karyawan</div>
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#75B8C0;">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4a4 4 0 10-8 0 4 4 0 008 0zm8 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-semibold" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">{{ $stats['users'] }}</div>
                </div>
                <div class="bg-white rounded-xl p-6 border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-sm text-[#5B6B68]">Total Penugasan</div>
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#F4A261;">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-semibold" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">{{ $stats['assignments'] }}</div>
                </div>
                <div class="bg-white rounded-xl p-6 border-2 sm:col-span-2 lg:col-span-1" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-sm text-[#5B6B68]">Penilaian Selesai</div>
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#16302E;">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-semibold" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">{{ $stats['assessments'] }}</div>
                </div>
            </div>

            <!-- Analytics: Compact View -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-5 rounded-xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <h3 class="font-semibold mb-3" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Ranking Departemen</h3>
                    <div class="space-y-2">
                        @forelse($deptAnalytics as $index => $dept)
                            <div class="flex items-center justify-between p-3 rounded-lg" style="background:#F1F6F5;">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 flex items-center justify-center rounded-full font-bold text-sm text-white"
                                         style="background:{{ $index == 0 ? '#F4A261' : ($index == 1 ? '#75B8C0' : '#16302E') }};">
                                        {{ $index + 1 }}
                                    </div>
                                    <a href="{{ route('admin.departments.show', \App\Models\Department::where('name', $dept['name'])->first()?->id) }}" 
                                       class="font-medium text-[#16302E] truncate hover:underline" title="{{ $dept['name'] }}">
                                       {{ $dept['name'] }}
                                    </a>
                                </div>
                                <div class="font-semibold text-lg relative z-10 flex items-center gap-2" style="font-family:'Space Grotesk', sans-serif; color:#75B8C0;">
                                    {{ $dept['avg'] }}
                                    @if($dept['trend'] != 0)
                                        <span class="text-xs {{ $dept['trend'] > 0 ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $dept['trend'] > 0 ? '▲' : '▼' }} {{ abs($dept['trend']) }}
                                        </span>
                                    @endif
                                    <div class="absolute bottom-0 left-0 h-1 bg-[#75B8C0]/30 rounded-full" style="width: 100%;">
                                        <div class="h-1 bg-[#75B8C0] rounded-full" style="width: {{ $dept['avg'] }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-[#5B6B68]">
                                <p>Belum ada data departemen untuk periode ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <h3 class="font-semibold mb-3" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Ranking Kategori</h3>
                    <div class="space-y-2">
                        @forelse($categoryAnalytics as $index => $cat)
                            <div class="flex items-center justify-between p-3 rounded-lg" style="background:#FDF3E7;">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 flex items-center justify-center rounded-full font-bold text-sm text-white"
                                         style="background:{{ $index == 0 ? '#F4A261' : ($index == 1 ? '#75B8C0' : '#16302E') }};">
                                        {{ $index + 1 }}
                                    </div>
                                    <span class="font-medium text-[#16302E] truncate" title="{{ $cat['name'] }}">{{ $cat['name'] }}</span>
                                </div>
                                <div class="font-semibold text-lg relative z-10 flex items-center gap-2" style="font-family:'Space Grotesk', sans-serif; color:#D97757;">
                                    {{ $cat['avg'] }}
                                    @if($cat['trend'] != 0)
                                        <span class="text-xs {{ $cat['trend'] > 0 ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $cat['trend'] > 0 ? '▲' : '▼' }} {{ abs($cat['trend']) }}
                                        </span>
                                    @endif
                                    <div class="absolute bottom-0 left-0 h-1 bg-[#D97757]/30 rounded-full" style="width: 100%;">
                                        <div class="h-1 bg-[#D97757] rounded-full" style="width: {{ $cat['avg'] }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-[#5B6B68]">
                                <p>Belum ada data kategori untuk periode ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Chart -->
            <div class="bg-white p-6 rounded-xl border-2 mb-6 relative overflow-hidden" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Tren Rata-Rata Nilai per Periode</h3>
                    <span class="text-xs font-medium px-3 py-1 rounded-full" style="background:#F1F6F5; color:#5B6B68;">Skala 0 - 5</span>
                </div>
                <div class="relative" style="height: 340px;">
                    <canvas id="kpiChart"></canvas>
                </div>
            </div>

            <!-- Manufacturing & Office Leaderboards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Manufacturing Leaderboard -->
                <div class="bg-white p-6 rounded-xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <h3 class="text-lg font-bold mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Ranking: Manufacturing</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-semibold mb-2" style="color:#75B8C0;">Top 5</h4>
                            <table class="w-full text-sm">
                                @foreach($topManufacturing as $user)
                                    <tr class="border-b last:border-0" style="border-color:#EEF2F1;">
                                        <td class="py-2 text-[#16302E]">{{ $user['name'] }}</td>
                                        <td class="py-2 text-right font-bold" style="color:#75B8C0;">{{ number_format($user['avg_score'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold mb-2" style="color:#E08E4E;">Bottom 5</h4>
                            <table class="w-full text-sm">
                                @foreach($bottomManufacturing as $user)
                                    <tr class="border-b last:border-0" style="border-color:#EEF2F1;">
                                        <td class="py-2 text-[#16302E]">{{ $user['name'] }}</td>
                                        <td class="py-2 text-right font-bold" style="color:#E08E4E;">{{ number_format($user['avg_score'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Office Leaderboard -->
                <div class="bg-white p-6 rounded-xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <h3 class="text-lg font-bold mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Ranking: Office</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-semibold mb-2" style="color:#75B8C0;">Top 5</h4>
                            <table class="w-full text-sm">
                                @foreach($topOffice as $user)
                                    <tr class="border-b last:border-0" style="border-color:#EEF2F1;">
                                        <td class="py-2 text-[#16302E]">{{ $user['name'] }}</td>
                                        <td class="py-2 text-right font-bold" style="color:#75B8C0;">{{ number_format($user['avg_score'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold mb-2" style="color:#E08E4E;">Bottom 5</h4>
                            <table class="w-full text-sm">
                                @foreach($bottomOffice as $user)
                                    <tr class="border-b last:border-0" style="border-color:#EEF2F1;">
                                        <td class="py-2 text-[#16302E]">{{ $user['name'] }}</td>
                                        <td class="py-2 text-right font-bold" style="color:#E08E4E;">{{ number_format($user['avg_score'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white p-6 rounded-xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <h4 class="font-semibold mb-2" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Sinkronisasi Penugasan</h4>
                    <p class="text-sm text-[#5B6B68] mb-4">Update daftar penilaian setelah perubahan hirarki.</p>
                    <form action="{{ route('admin.assignments.refresh') }}" method="POST">
                        @csrf
                        <button type="submit" class="font-medium py-2.5 px-5 rounded-lg text-white border-2 transition-all hover:-translate-y-0.5"
                                style="background:#F4A261; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                            Refresh Penugasan
                        </button>
                    </form>
                </div>
                <div class="bg-white p-6 rounded-xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <h4 class="font-semibold mb-2" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Hasil Penilaian</h4>
                    <p class="text-sm text-[#5B6B68] mb-4">Lihat detail skor penilaian seluruh karyawan.</p>
                    <a href="{{ route('admin.results.index') }}" class="inline-block font-medium py-2.5 px-5 rounded-lg text-white border-2 transition-all hover:-translate-y-0.5"
                       style="background:#75B8C0; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                        Lihat Semua Hasil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('periodSelect').addEventListener('change', function() {
            window.location.href = `{{ route('admin.dashboard') }}?period_id=${this.value}`;
        });

        const labels = {!! json_encode($chartData->keys()->toArray()) !!};
        const dataValues = {!! json_encode($chartData->values()->toArray()) !!};

        const ctx = document.getElementById('kpiChart').getContext('2d');

        // Gradient area fill (teal -> transparent)
        const areaGradient = ctx.createLinearGradient(0, 0, 0, 340);
        areaGradient.addColorStop(0, 'rgba(117, 184, 192, 0.35)');
        areaGradient.addColorStop(0.6, 'rgba(117, 184, 192, 0.08)');
        areaGradient.addColorStop(1, 'rgba(117, 184, 192, 0)');

        // Gradient line (teal -> orange)
        const lineGradient = ctx.createLinearGradient(0, 0, ctx.canvas.width || 600, 0);
        lineGradient.addColorStop(0, '#75B8C0');
        lineGradient.addColorStop(1, '#F4A261');

        // Plugin: glow di belakang titik terakhir (data terbaru) biar mata langsung ketarik ke situ
        const glowLastPoint = {
            id: 'glowLastPoint',
            afterDatasetsDraw(chart) {
                const { ctx: c } = chart;
                const meta = chart.getDatasetMeta(0);
                const point = meta.data[meta.data.length - 1];
                if (!point) return;
                c.save();
                c.beginPath();
                const glow = c.createRadialGradient(point.x, point.y, 0, point.x, point.y, 18);
                glow.addColorStop(0, 'rgba(244, 162, 97, 0.35)');
                glow.addColorStop(1, 'rgba(244, 162, 97, 0)');
                c.fillStyle = glow;
                c.arc(point.x, point.y, 18, 0, Math.PI * 2);
                c.fill();
                c.restore();
            }
        };

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-Rata Nilai',
                    data: dataValues,
                    borderColor: lineGradient,
                    backgroundColor: areaGradient,
                    borderWidth: 3.5,
                    fill: true,
                    tension: 0.45,
                    cubicInterpolationMode: 'monotone',
                    pointRadius: 5,
                    pointHoverRadius: 9,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#75B8C0',
                    pointBorderWidth: 3,
                    pointHoverBackgroundColor: '#F4A261',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3,
                    pointHitRadius: 20
                }]
            },
            plugins: [glowLastPoint],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                animations: {
                    y: {
                        easing: 'easeOutElastic',
                        from: (ctx) => ctx.type === 'data' ? 340 : undefined,
                        duration: 1400,
                        delay: (ctx) => ctx.dataIndex * 90
                    },
                    x: {
                        easing: 'easeOutQuart',
                        duration: 900
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(22, 48, 46, 0.94)',
                        titleColor: '#B7DCE0',
                        titleFont: { size: 12, weight: '500' },
                        bodyColor: '#fff',
                        bodyFont: { size: 15, weight: 'bold' },
                        padding: 14,
                        cornerRadius: 10,
                        displayColors: false,
                        caretSize: 6,
                        callbacks: {
                            label: (context) => `Nilai: ${context.parsed.y}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                        ticks: {
                            font: { size: 12 },
                            color: '#9ca3af',
                            padding: 8
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 12, weight: '500' },
                            color: '#6b7280'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
