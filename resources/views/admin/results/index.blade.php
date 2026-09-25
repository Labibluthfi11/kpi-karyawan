<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Hasil Penilaian Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Periode & Ekspor -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <form action="{{ route('admin.results.index') }}" method="GET" class="flex gap-3 items-center">
                    <label class="font-semibold text-[#16302E]">Periode:</label>
                    <select name="period_id" onchange="this.form.submit()" class="border-2 rounded-lg px-3 py-2 focus:ring-0 focus:border-[#75B8C0]" style="border-color:#16302E;">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ $periodId == $period->id ? 'selected' : '' }}>
                                {{ $period->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="flex gap-2">
                    <a href="{{ route('admin.results.export.excel', ['period_id' => $periodId]) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#2F5B1F] text-white rounded-lg font-semibold text-xs border-2 transition-all hover:-translate-y-0.5"
                       style="border-color:#16302E; box-shadow:2px 2px 0px 0px #16302E;">
                         Ekspor Excel
                    </a>
                    <a href="{{ route('admin.results.export.pdf', ['period_id' => $periodId]) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#D97757] text-white rounded-lg font-semibold text-xs border-2 transition-all hover:-translate-y-0.5"
                       style="border-color:#16302E; box-shadow:2px 2px 0px 0px #16302E;">
                         Cetak PDF
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($processedDepartments as $dept)
                    @php
                        $palette = ['#75B8C0', '#F4A261', '#16302E'];
                        $accent = $palette[$loop->index % 3];
                    @endphp
                    <div class="bg-white rounded-xl border-2 overflow-hidden"
                         x-data="{ search: '' }"
                         style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                        <div class="p-4 flex items-center justify-between" style="background:#F1F6F5;">
                            <div>
                                <h3 class="font-semibold text-lg" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">{{ $dept['name'] }}</h3>
                                <div class="text-xs text-[#5B6B68]">
                                    {{ $dept['user_count'] }} Karyawan | Rata-rata: <span class="font-bold text-[#16302E]">{{ $dept['avg'] }}</span>
                                </div>
                            </div>
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background:{{ $accent }};">
                                <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="px-4 pt-4">
                            <input type="text" x-model="search" placeholder="Cari nama karyawan..."
                                   class="w-full text-xs border-2 rounded-lg px-3 py-2 focus:outline-none"
                                   style="border-color:#16302E;">
                        </div>

                        <div class="p-4">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b" style="border-color:#EEF2F1;">
                                        <th class="py-2 font-medium text-[#5B6B68]">Nama</th>
                                        <th class="py-2 text-center font-medium text-[#5B6B68]">Nilai</th>
                                        <th class="py-2 text-right font-medium text-[#5B6B68]">Lihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dept['users'] as $user)
                                        @php
                                            $avg = $user['avg'];
                                            $color = $avg >= 4 ? '#2F5B1F' : ($avg >= 3 ? '#16302E' : '#D97757');
                                            $bg = $avg >= 4 ? '#E8F4E0' : ($avg >= 3 ? '#F1F6F5' : '#FDE8E4');
                                        @endphp
                                        <tr class="border-b last:border-0 user-row"
                                            x-show="'{{ strtolower($user['name']) }}'.includes(search.toLowerCase())"
                                            style="border-color:#EEF2F1;">
                                            <td class="py-2.5 font-medium" style="color:#16302E;">{{ $user['name'] }}</td>
                                            <td class="py-2.5 text-center">
                                                <span class="inline-block px-2.5 py-0.5 rounded font-semibold text-xs" style="background:{{ $bg }}; color:{{ $color }};">
                                                    {{ $avg > 0 ? $avg : '-' }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 text-right">
                                                <a href="{{ route('admin.results.show', [$user['id'], 'period_id' => $periodId]) }}"
                                                   class="text-xs font-semibold px-3 py-1 rounded-lg border-2 transition-all hover:bg-[#16302E] hover:text-white"
                                                   style="color:#75B8C0; border-color:#75B8C0;">Detail</a>
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
