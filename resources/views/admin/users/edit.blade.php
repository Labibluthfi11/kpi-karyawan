<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Karyawan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <input type="text" name="name" class="border p-2 w-full" value="{{ $user->name }}" required>
                    <select name="department_id" class="border p-2 w-full" required>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ $user->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <select name="role_id" class="border p-2 w-full" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <select name="supervisor_id" class="border p-2 w-full">
                        <option value="">Pilih Atasan (Opsional)</option>
                        @foreach($potentialSupervisors as $u)
                            <option value="{{ $u->id }}" {{ $user->supervisor_id == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                    <div class="text-sm text-gray-500">PIN Karyawan: <strong>{{ $user->pin }}</strong></div>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded">Update</button>
                    </form>
            </div>
        </div>
    </div>
</x-app-layout>
