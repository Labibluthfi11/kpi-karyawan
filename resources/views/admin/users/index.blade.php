<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Karyawan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('admin.users.create') }}" class="bg-black text-white px-4 py-2 rounded">Tambah Karyawan</a>
                    <input type="text" id="searchInput" placeholder="Cari karyawan..." class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                
                <table class="w-full mt-4" id="usersTable">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Nama</th>
                            <th class="text-left py-2">Divisi</th>
                            <th class="text-left py-2">Role</th>
                            <th class="text-left py-2">PIN</th>
                            <th class="text-right py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b user-row">
                                <td class="py-2 user-name">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->department?->name ?? '-' }}</td>
                                <td class="py-2">{{ $user->role?->name ?? '-' }}</td>
                                <td class="py-2 font-mono font-bold">{{ $user->pin }}</td>
                                <td class="text-right py-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
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

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#usersTable tbody .user-row');

            rows.forEach(row => {
                let name = row.querySelector('.user-name').innerText.toLowerCase();
                if (name.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
