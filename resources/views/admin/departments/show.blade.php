<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Detail Departemen: {{ $department->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border-2 p-6" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                <h3 class="font-semibold text-lg mb-4" style="color:#16302E;">Daftar Karyawan</h3>
                
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b" style="border-color:#EEF2F1;">
                            <th class="py-3 font-medium text-[#5B6B68]">Nama</th>
                            <th class="py-3 font-medium text-[#5B6B68]">Rata-rata Nilai</th>
                            <th class="py-3 font-medium text-[#5B6B68]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            @php
                                $scores = $user->assessmentsReceived->flatMap->results->pluck('score');
                                $avg = $scores->avg() ? number_format($scores->avg(), 2) : 'Belum dinilai';
                            @endphp
                            <tr class="border-b last:border-0" style="border-color:#EEF2F1;">
                                <td class="py-4 font-medium" style="color:#16302E;">{{ $user->name }}</td>
                                <td class="py-4 font-semibold" style="color:#75B8C0;">{{ $avg }}</td>
                                <td class="py-4">
                                    <a href="{{ route('admin.results.show', $user) }}" class="text-[#F4A261] hover:underline">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-[#5B6B68]">Belum ada karyawan atau penilaian di departemen ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
