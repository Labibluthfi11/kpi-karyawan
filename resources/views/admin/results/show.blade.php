<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Penilaian: {{ $user->name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($assessments as $assessment)
                <div class="bg-white p-6 rounded shadow mb-6">
                    <h3 class="font-bold text-lg mb-2">Dinilai oleh: {{ $assessment->evaluator->name }} ({{ $assessment->assessment_date }})</h3>
                    @php
                        // Kelompokkan hasil berdasarkan kategori
                        $groupedResults = $assessment->results->groupBy('question.category');
                    @endphp

                    @foreach($groupedResults as $category => $results)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-700 bg-gray-50 p-2 rounded">{{ $category }}</h4>
                            <table class="w-full">
                                @foreach($results as $result)
                                    <tr class="border-b">
                                        <td class="p-2 pl-4 text-sm text-gray-600">{{ $result->question->question_text }}</td>
                                        <td class="p-2 font-bold text-sm">
                                            @php
                                                $labels = [
                                                    1 => 'Sangat Kurang',
                                                    2 => 'Kurang',
                                                    3 => 'Cukup',
                                                    4 => 'Baik',
                                                    5 => 'Sangat Baik',
                                                ];
                                            @endphp
                                            {{ $labels[$result->score] ?? $result->score }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow text-center">Belum ada penilaian.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
