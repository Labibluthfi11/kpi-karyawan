<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.periods.index') }}" class="text-[#5B6B68] hover:text-[#16302E]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                Tambah Periode
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border-2 p-6" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">

                <form action="{{ route('admin.periods.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Nama Periode</label>
                        <input type="text" id="name" name="name"
                               class="border-2 rounded-lg px-3.5 py-2.5 w-full transition-all focus:outline-none"
                               style="border-color:#16302E;"
                               onfocus="this.style.boxShadow='3px 3px 0px 0px #16302E'; this.style.transform='translate(-1px,-1px)';"
                               onblur="this.style.boxShadow='none'; this.style.transform='none';"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date"
                                   class="border-2 rounded-lg px-3.5 py-2.5 w-full transition-all focus:outline-none"
                                   style="border-color:#16302E;"
                                   onfocus="this.style.boxShadow='3px 3px 0px 0px #16302E'; this.style.transform='translate(-1px,-1px)';"
                                   onblur="this.style.boxShadow='none'; this.style.transform='none';"
                                   value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Tanggal Selesai</label>
                            <input type="date" id="end_date" name="end_date"
                                   class="border-2 rounded-lg px-3.5 py-2.5 w-full transition-all focus:outline-none"
                                   style="border-color:#16302E;"
                                   onfocus="this.style.boxShadow='3px 3px 0px 0px #16302E'; this.style.transform='translate(-1px,-1px)';"
                                   onblur="this.style.boxShadow='none'; this.style.transform='none';"
                                   value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="rounded" style="accent-color:#F4A261;" {{ old('is_active') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm" style="color:#16302E;">Aktifkan Periode</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="font-medium py-2.5 px-6 rounded-lg text-white border-2 transition-all hover:-translate-y-0.5"
                                style="background:#F4A261; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                            Simpan
                        </button>
                        <a href="{{ route('admin.periods.index') }}" class="text-sm font-medium" style="color:#5B6B68;">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
