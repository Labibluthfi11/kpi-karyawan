<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Manajemen Divisi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-[#5B6B68]">{{ count($departments) }} divisi terdaftar</p>
                <a href="{{ route('admin.departments.create') }}"
                   class="font-medium py-2.5 px-5 rounded-lg text-white border-2 inline-flex items-center gap-2 transition-all hover:-translate-y-0.5"
                   style="background:#F4A261; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Divisi
                </a>
            </div>

            @if(count($departments) === 0)
                <div class="bg-white rounded-xl border-2 p-10 text-center" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <p class="text-[#5B6B68]">Belum ada divisi. Klik "Tambah Divisi" untuk membuat yang pertama.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($departments as $dept)
                        @php
                            $palette = ['#75B8C0', '#F4A261', '#16302E'];
                            $accent = $palette[$loop->index % 3];
                            $badgeBg = $accent === '#F4A261' ? '#FDF3E7' : '#F1F6F5';
                        @endphp
                        <div class="bg-white rounded-xl border-2 p-5 transition-all hover:-translate-y-0.5" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:{{ $accent }};">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m4-4h.01M11 17h.01M7 13h.01M11 13h.01M7 9h.01M11 9h.01M15 9h.01M15 13h.01M15 17h.01"/>
                                    </svg>
                                </div>
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium capitalize" style="background:{{ $badgeBg }}; color:#16302E;">
                                    {{ $dept->group ?? '-' }}
                                </span>
                            </div>

                            <h3 class="font-semibold text-lg mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                                {{ $dept->name }}
                            </h3>

                            <div class="flex items-center gap-4 pt-3 border-t" style="border-color:#EEF2F1;">
                                <a href="{{ route('admin.departments.edit', $dept) }}" class="text-sm font-medium" style="color:#75B8C0;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="inline">
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
