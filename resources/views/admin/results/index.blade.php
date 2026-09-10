<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hasil Penilaian Karyawan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($users as $departmentName => $deptUsers)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 p-4 border-b border-gray-200">
                            <h3 class="font-bold text-lg text-gray-800">{{ $departmentName }}</h3>
                            <span class="text-xs text-gray-500">{{ $deptUsers->count() }} Karyawan</span>
                        </div>

                        <div class="p-4">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500 border-b">
                                        <th class="py-2">Nama</th>
                                        <th class="py-2 text-center">Nilai</th>
                                        <th class="py-2 text-right">Lihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deptUsers as $user)
                                        @php
                                            $assessments = \App\Models\KpiAssessment::where('evaluatee_id', $user->id)->with('results')->get();
                                            $totalScore = 0;
                                            $count = 0;
                                            foreach ($assessments as $a) {
                                                foreach ($a->results as $r) {
                                                    $totalScore += $r->score;
                                                    $count++;
                                                }
                                            }
                                            $avg = $count > 0 ? number_format($totalScore / $count, 2) : '-';
                                        @endphp
                                        <tr class="border-b last:border-0">
                                            <td class="py-2 font-medium">{{ $user->name }}</td>
                                            <td class="py-2 text-center font-bold">{{ $avg }}</td>
                                            <td class="py-2 text-right">
                                                <a href="{{ route('admin.results.show', $user) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
