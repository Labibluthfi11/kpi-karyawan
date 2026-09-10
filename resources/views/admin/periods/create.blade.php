<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Periode</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.periods.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="name" value="Nama Periode" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="start_date" value="Tanggal Mulai" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="end_date" value="Tanggal Selesai" />
                            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" required />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2">Aktifkan Periode</span>
                        </label>
                    </div>
                    <x-primary-button>Simpan</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
