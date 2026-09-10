<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Karyawan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="name" class="border p-2 w-full" placeholder="Nama" required>
                    <select name="department_id" class="border p-2 w-full" required>
                        <option value="">Pilih Divisi</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <select name="role_id" class="border p-2 w-full" required>
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <select name="supervisor_id" class="border p-2 w-full">
                        <option value="">Pilih Atasan (Opsional)</option>
                        @foreach($potentialSupervisors as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
