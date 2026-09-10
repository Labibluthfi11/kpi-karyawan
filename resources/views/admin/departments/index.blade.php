<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Divisi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('admin.departments.create') }}" class="bg-black text-white px-4 py-2 rounded">Tambah Divisi</a>

                <table class="w-full mt-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Nama Divisi</th>
                            <th class="text-left py-2">Departement</th>
                            <th class="text-right py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $dept)
                            <tr class="border-b">
                                <td class="py-2">{{ $dept->name }}</td>
                                <td class="py-2 capitalize">{{ $dept->group ?? '-' }}</td>
                                <td class="text-right py-2">
                                    <a href="{{ route('admin.departments.edit', $dept) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
