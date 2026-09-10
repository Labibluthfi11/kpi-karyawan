<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Divisi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('admin.departments.update', $department) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <input type="text" name="name" class="border p-2 w-full" value="{{ $department->name }}" required>
                    <select name="group" class="border p-2 w-full" required>
                        <option value="manufacturing" {{ $department->group == 'manufacturing' ? 'selected' : '' }}>Manufacturing (Produksi)</option>
                        <option value="office" {{ $department->group == 'office' ? 'selected' : '' }}>Office</option>
                    </select>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
