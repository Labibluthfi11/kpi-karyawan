<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mapping Penilaian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow mb-6">
                <form action="{{ route('admin.assignments.store') }}" method="POST" class="flex gap-4 items-end">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-medium">Penilai</label>
                        <select name="evaluator_id" class="w-full border p-2 rounded" required>
                            <option value="">Pilih Penilai</option>
                            @foreach($departments as $dept)
                                <optgroup label="{{ $dept->name }}">
                                    @foreach($dept->users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium">Yang Dinilai</label>
                        <select name="evaluatee_id" class="w-full border p-2 rounded" required>
                            <option value="">Pilih Karyawan</option>
                            @foreach($departments as $dept)
                                <optgroup label="{{ $dept->name }}">
                                    @foreach($dept->users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded">Tambahkan</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Penilai</th>
                            <th class="text-left py-2">Dinilai</th>
                            <th class="text-left py-2">Status</th>
                            <th class="text-right py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assign)
                            <tr class="border-b">
                                <td class="py-2">{{ $assign->evaluator->name }}</td>
                                <td class="py-2">{{ $assign->evaluatee->name }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded {{ $assign->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($assign->status) }}
                                    </span>
                                </td>
                                <td class="text-right py-2">
                                    <form action="{{ route('admin.assignments.destroy', $assign) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500" onclick="return confirm('Hapus?')">Hapus</button>
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
