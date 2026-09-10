<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Divisi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="name" class="border p-2 w-full" placeholder="Nama Divisi" required>
                    <select name="group" class="border p-2 w-full" required>
                        <option value="">Pilih Kelompok</option>
                        <option value="manufacturing">Manufacturing (Produksi)</option>
                        <option value="office">Office</option>
                    </select>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
