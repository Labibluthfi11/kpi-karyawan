<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Manajemen Periode Penilaian
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-[#5B6B68]">{{ count($periods) }} periode terdaftar</p>
                <a href="{{ route('admin.periods.create') }}"
                   class="font-medium py-2.5 px-5 rounded-lg text-white border-2 inline-flex items-center gap-2 transition-all hover:-translate-y-0.5"
                   style="background:#F4A261; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Periode
                </a>
            </div>

            @if(count($periods) === 0)
                <div class="bg-white rounded-xl border-2 p-10 text-center" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <p class="text-[#5B6B68]">Belum ada periode. Klik "Tambah Periode" untuk membuat yang pertama.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($periods as $period)
                        <div class="bg-white rounded-xl border-2 p-5 transition-all hover:-translate-y-0.5" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#75B8C0;">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium"
                                      style="background: {{ $period->is_active ? '#E8F4E0' : '#F1F6F5' }}; color: {{ $period->is_active ? '#2F5B1F' : '#5B6B68' }};">
                                    {{ $period->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </div>

                            <h3 class="font-semibold text-lg mb-2" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                                {{ $period->name }}
                            </h3>

                            <p class="text-sm text-[#5B6B68] mb-4">
                                {{ $period->start_date->format('d M Y') }} &mdash; {{ $period->end_date->format('d M Y') }}
                            </p>

                            <div class="flex items-center gap-4 pt-3 border-t" style="border-color:#EEF2F1;">
                                <a href="{{ route('admin.periods.edit', $period) }}" class="text-sm font-medium" style="color:#75B8C0;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.periods.destroy', $period) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium" style="color:#D97757;" onclick="return confirm('Hapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
