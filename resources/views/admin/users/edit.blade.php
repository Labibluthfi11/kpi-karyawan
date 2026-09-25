<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="text-[#5B6B68] hover:text-[#16302E]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                Edit Karyawan
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border-2 p-6" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">

                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Nama Karyawan</label>
                        <input type="text" id="name" name="name"
                               class="border-2 rounded-lg px-3.5 py-2.5 w-full transition-all focus:outline-none"
                               style="border-color:#16302E;"
                               onfocus="this.style.boxShadow='3px 3px 0px 0px #16302E'; this.style.transform='translate(-1px,-1px)';"
                               onblur="this.style.boxShadow='none'; this.style.transform='none';"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department_id" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Divisi</label>
                        <select id="department_id" name="department_id"
                                class="border-2 rounded-lg px-3.5 py-2.5 w-full transition-all focus:outline-none bg-white"
                                style="border-color:#16302E;"
                                onfocus="this.style.boxShadow='3px 3px 0px 0px #16302E'; this.style.transform='translate(-1px,-1px)';"
                                onblur="this.style.boxShadow='none'; this.style.transform='none';"
                                required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role_id" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Role</label>
                        <select id="role_id" name="role_id"
                                class="border-2 rounded-lg px-3.5 py-2.5 w-full transition-all focus:outline-none bg-white"
                                style="border-color:#16302E;"
                                onfocus="this.style.boxShadow='3px 3px 0px 0px #16302E'; this.style.transform='translate(-1px,-1px)';"
                                onblur="this.style.boxShadow='none'; this.style.transform='none';"
                                required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supervisor_id" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Atasan</label>
                        <select id="supervisor_id" name="supervisor_id"
                                class="border-2 rounded-lg px-3.5 py-2.5 w-full transition-all focus:outline-none bg-white"
                                style="border-color:#16302E;"
                                onfocus="this.style.boxShadow='3px 3px 0px 0px #16302E'; this.style.transform='translate(-1px,-1px)';"
                                onblur="this.style.boxShadow='none'; this.style.transform='none';">
                            <option value="">Pilih Atasan (Opsional)</option>
                            @foreach($potentialSupervisors as $u)
                                <option value="{{ $u->id }}" {{ old('supervisor_id', $user->supervisor_id) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('supervisor_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-sm px-3.5 py-2.5 rounded-lg" style="background:#F1F6F5; color:#5B6B68;">
                        PIN Karyawan: <strong class="font-mono" style="color:#16302E;">{{ $user->pin }}</strong>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="font-medium py-2.5 px-6 rounded-lg text-white border-2 transition-all hover:-translate-y-0.5"
                                style="background:#F4A261; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                            Update
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium" style="color:#5B6B68;">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
