<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard HRD - Monitoring KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
            @endif

            <!-- Ringkasan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500">Total Karyawan</div>
                    <div class="text-3xl font-bold">{{ $stats['users'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-sm text-gray-500">Total Penugasan</div>
                    <div class="text-3xl font-bold">{{ $stats['assignments'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm text-gray-500">Penilaian Selesai</div>
                    <div class="text-3xl font-bold">{{ $stats['assessments'] }}</div>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
                <h3 class="text-lg font-bold mb-4">Tren Rata-Rata Nilai per Periode</h3>
                <canvas id="kpiChart" height="100"></canvas>
            </div>

            <!-- Top & Bottom Performers -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-green-600">Top 5 Performer</h3>
                    <table class="w-full">
                        @foreach($topPerformers as $user)
                            <tr class="border-b last:border-0">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2 text-right font-bold">{{ number_format($user->avg_score, 2) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-red-600">Bottom 5 Performer</h3>
                    <table class="w-full">
                        @foreach($bottomPerformers as $user)
                            <tr class="border-b last:border-0">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2 text-right font-bold">{{ number_format($user->avg_score, 2) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-2">Sinkronisasi Penugasan</h4>
                    <p class="text-sm text-gray-600 mb-4">Update daftar penilaian setelah perubahan hirarki.</p>
                    <form action="{{ route('admin.assignments.refresh') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            Refresh Penugasan
                        </button>
                    </form>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-2">Hasil Penilaian</h4>
                    <p class="text-sm text-gray-600 mb-4">Lihat detail skor penilaian seluruh karyawan.</p>
                    <a href="{{ route('admin.results.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Lihat Semua Hasil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('kpiChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData->keys()) !!},
                datasets: [{
                    label: 'Rata-Rata Nilai',
                    data: {!! json_encode($chartData->values()) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            },
            options: { scales: { y: { beginAtZero: true, max: 5 } } }
        });
    </script>
</x-app-layout>
