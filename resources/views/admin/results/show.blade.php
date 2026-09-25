<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Detail Penilaian: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.results.index', ['period_id' => request('period_id')]) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border-2 rounded-lg font-semibold text-sm transition-all hover:-translate-x-1"
                   style="border-color:#16302E; color:#16302E; box-shadow:2px 2px 0px 0px #16302E;">
                    ← Kembali
                </a>
            </div>
            @forelse($assessments as $assessment)
                @php
                    $allScores = $assessment->results->pluck('score');
                    $avgScore = $allScores->avg() ? number_format($allScores->avg(), 2) : '0.00';
                @endphp
                <div class="bg-white p-6 rounded-xl border-2 mb-6" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="font-bold text-lg" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                            Dinilai oleh: {{ $assessment->evaluator->name }} 
                            <span class="text-sm font-normal text-[#5B6B68]">({{ $assessment->assessment_date }})</span>
                        </h3>
                        <div class="text-right">
                            <div class="text-sm text-[#5B6B68]">Skor Rata-rata</div>
                            <div class="text-2xl font-bold" style="color:#75B8C0; font-family:'Space Grotesk', sans-serif;">{{ $avgScore }} / 5.00</div>
                        </div>
                    </div>
                    
                    @if($assessment->general_note)
                        <div class="mb-6 p-4 bg-[#F1F6F5] rounded-xl border border-[#16302E]/10">
                            <h4 class="font-bold text-sm mb-1" style="color:#16302E;">Catatan Umum:</h4>
                            <p class="text-sm text-[#5B6B68] italic">{{ $assessment->general_note }}</p>
                        </div>
                    @endif
                    
                    @php
                        $groupedResults = $assessment->results->groupBy('question.category');
                    @endphp

                    @foreach($groupedResults as $category => $results)
                        @php
                            $catScores = $results->pluck('score');
                            $catAvg = $catScores->avg() ?? 0;
                            $catPercentage = ($catAvg / 5) * 100;
                        @endphp
                        <div class="mb-8 last:mb-0">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold text-[#16302E]" style="font-family:'Space Grotesk', sans-serif;">
                                    {{ $category }}
                                </h4>
                                <span class="text-sm font-bold" style="color:#75B8C0;">{{ number_format($catAvg, 2) }}</span>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="w-full bg-[#F1F6F5] rounded-full h-2.5 mb-4 border border-[#16302E]/10">
                                <div class="h-2.5 rounded-full" style="width: {{ $catPercentage }}%; background:{{ $catAvg >= 4 ? '#2F5B1F' : ($catAvg >= 3 ? '#75B8C0' : '#D97757') }};"></div>
                            </div>

                            <div class="space-y-3">
                                @foreach($results as $result)
                                    @php
                                        $score = $result->score;
                                        $color = $score >= 4 ? '#2F5B1F' : ($score >= 3 ? '#16302E' : '#D97757');
                                        $bg = $score >= 4 ? '#E8F4E0' : ($score >= 3 ? '#F1F6F5' : '#FDE8E4');
                                        $labels = [1 => 'Sangat Kurang', 2 => 'Kurang', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'];
                                    @endphp
                                    <div class="flex justify-between items-center border-b pb-3 last:border-b-0 last:pb-0" style="border-color:#EEF2F1;">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm text-[#5B6B68]">{{ $result->question->question_text }}</span>
                                            @if($result->note)
                                                <span class="text-xs text-[#16302E] bg-[#EEF2F1] px-2 py-1 rounded italic mt-1">Catatan: {{ $result->note }}</span>
                                            @endif
                                        </div>
                                        <span class="text-xs font-bold px-3 py-1 rounded-full shrink-0" style="background:{{ $bg }}; color:{{ $color }};">
                                            {{ $labels[$score] ?? $score }} ({{ $score }})
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="bg-white p-8 rounded-xl border-2 text-center" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <p class="text-[#5B6B68]">Belum ada penilaian.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
