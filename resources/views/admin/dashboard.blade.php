<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard HRD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Ringkasan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500">Total Karyawan</div>
                    <div class="text-3xl font-bold">{{ \App\Models\User::count() }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm text-gray-500">Total Divisi</div>
                    <div class="text-3xl font-bold">{{ \App\Models\Department::count() }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm text-gray-500">Penilaian Bulan Ini</div>
                    <div class="text-3xl font-bold">{{ \App\Models\KpiAssessment::whereMonth('created_at', now()->month)->count() }}</div>
                </div>
            </div>

            <!-- Tabel Singkat Performa -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Ringkasan Performa Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Nama Karyawan</th>
                                <th class="px-6 py-3">Divisi</th>
                                <th class="px-6 py-3">Tanggal Penilaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\KpiAssessment::latest()->take(5)->get() as $assessment)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $assessment->evaluatee->name }}</td>
                                <td class="px-6 py-4">{{ $assessment->evaluatee->department->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $assessment->assessment_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
