<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Periode Penilaian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('admin.periods.create') }}" class="bg-black text-white px-4 py-2 rounded">Tambah Periode</a>
                
                <table class="w-full mt-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Nama</th>
                            <th class="text-left py-2">Mulai</th>
                            <th class="text-left py-2">Selesai</th>
                            <th class="text-left py-2">Status</th>
                            <th class="text-right py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periods as $period)
                            <tr class="border-b">
                                <td class="py-2">{{ $period->name }}</td>
                                <td class="py-2">{{ $period->start_date->format('d M Y') }}</td>
                                <td class="py-2">{{ $period->end_date->format('d M Y') }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded {{ $period->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $period->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td class="text-right py-2">
                                    <a href="{{ route('admin.periods.edit', $period) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('admin.periods.destroy', $period) }}" method="POST" class="inline">
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
