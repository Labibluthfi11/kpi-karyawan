<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Manajemen Karyawan
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ search: '', roleFilter: 'Semua' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl border-2 bg-green-50" style="border-color:#16302E; color:#16302E;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col gap-4 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                    <a href="{{ route('admin.users.create') }}"
                       class="font-medium py-2.5 px-5 rounded-lg text-white border-2 inline-flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5"
                       style="background:#F4A261; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Karyawan
                    </a>
                    <input type="text" id="searchInput" x-model="search" placeholder="Cari karyawan..."
                           class="border-2 rounded-lg px-3.5 py-2.5 w-full sm:w-72 transition-all focus:outline-none"
                           style="border-color:#16302E;">
                </div>

                <!-- Filters -->
                <div class="flex gap-2">
                    @foreach(['Semua', 'Leader', 'Anggota'] as $role)
                        <button x-on:click="roleFilter = '{{ $role }}'"
                                :class="roleFilter === '{{ $role }}' ? 'text-white' : 'text-[#16302E] bg-white'"
                                class="px-4 py-2 rounded-lg border-2 font-medium transition-all"
                                style="border-color:#16302E;"
                                :style="roleFilter === '{{ $role }}' ? 'background:#16302E;' : ''">
                            {{ $role }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="usersGrid">
                @foreach($users as $departmentName => $deptUsers)
                    @php
                        $palette = ['#75B8C0', '#F4A261', '#16302E'];
                        $accent = $palette[$loop->index % 3];
                    @endphp
                    <div class="bg-white rounded-xl border-2 overflow-hidden" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                        <div class="p-4 flex items-center justify-between" style="background:#F1F6F5;">
                            <div>
                                <h3 class="font-semibold text-lg" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">{{ $departmentName }}</h3>
                                <span class="text-xs text-[#5B6B68]">{{ $deptUsers->count() }} Karyawan</span>
                            </div>
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background:{{ $accent }};">
                                <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4a4 4 0 10-8 0 4 4 0 008 0zm8 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="p-4">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b" style="border-color:#EEF2F1;">
                                        <th class="py-2 font-medium text-[#5B6B68]">Nama</th>
                                        <th class="py-2 text-center font-medium text-[#5B6B68]">PIN</th>
                                        <th class="py-2 text-right font-medium text-[#5B6B68]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody x-data>
                                    <template x-for="user in {{ json_encode($deptUsers) }}" :key="user.id">
                                        <tr class="border-b last:border-0 user-row" 
                                            x-show="(roleFilter === 'Semua' || user.role.name === roleFilter) && user.name.toLowerCase().includes(search.toLowerCase())"
                                            style="border-color:#EEF2F1;">
                                            <td class="py-2.5 font-medium flex items-center gap-2" style="color:#16302E;">
                                                <span x-text="user.name"></span>
                                                <span x-text="user.role.name" 
                                                      class="text-[10px] px-1.5 py-0.5 rounded-md font-bold text-white"
                                                      :style="user.role.name === 'Leader' ? 'background:#75B8C0;' : 'background:#A0AEC0;'"></span>
                                            </td>
                                            <td class="py-2.5 text-center">
                                                <span class="inline-block px-2 py-0.5 rounded font-mono font-semibold text-xs" style="background:#F1F6F5; color:#16302E;" x-text="user.pin"></span>
                                            </td>
                                            <td class="py-2.5 text-right whitespace-nowrap">
                                                <a :href="'/admin/users/' + user.id + '/edit'" class="text-xs font-semibold px-3 py-1 rounded-lg border-2 mr-2 hover:bg-[#16302E] hover:text-white" style="color:#75B8C0; border-color:#75B8C0;">Edit</a>
                                                <button type="button" 
                                                        class="text-xs font-semibold px-3 py-1 rounded-lg border-2 transition-all hover:bg-[#D97757] hover:text-white" 
                                                        style="color:#D97757; border-color:#D97757;"
                                                        x-on:click="$dispatch('open-delete-modal', '/admin/users/' + user.id)">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr x-show="!{{ json_encode($deptUsers) }}.some(user => (roleFilter === 'Semua' || user.role.name === roleFilter) && user.name.toLowerCase().includes(search.toLowerCase()))">
                                        <td colspan="3" class="py-4 text-center text-[#5B6B68] text-xs">Karyawan tidak ditemukan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
...

    <!-- Custom Modal -->
    <div x-data="{ show: false }" 
         x-on:open-delete-modal.window="show = true; document.getElementById('delete-form').action = $event.detail;"
         x-on:close-modal.window="show = false"
         x-show="show" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display: none;">
         
        <!-- Overlay -->
        <div x-on:click="show = false" class="fixed inset-0 bg-[#16302E] opacity-50"></div>

        <!-- Modal Content -->
        <div class="bg-white p-6 rounded-xl border-2 z-10 w-full max-w-lg" 
             style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4">
             
            <h2 class="text-xl font-bold mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                Hapus Karyawan?
            </h2>
            <p class="mb-6 text-[#5B6B68]">Apakah anda yakin menghapus karyawan bangsat ini dari kpi?</p>
            
            <form id="delete-form" method="POST" class="flex justify-end gap-3">
                @csrf @method('DELETE')
                <button type="button" 
                        x-on:click="show = false"
                        class="font-medium py-2 px-5 rounded-lg border-2 transition-all"
                        style="border-color:#16302E; color:#16302E;">
                    Batal
                </button>
                <button type="submit" 
                        class="font-medium py-2 px-5 rounded-lg text-white border-2 transition-all"
                        style="background:#D97757; border-color:#16302E;">
                    Oke
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    let filter = this.value.toLowerCase();
                    let rows = document.querySelectorAll('.user-row');

                    rows.forEach(row => {
                        // Fixed: Search for .user-name correctly
                        let nameElement = row.querySelector('span[x-text="user.name"]');
                        let name = nameElement ? nameElement.innerText.toLowerCase() : '';
                        let card = row.closest('.bg-white');

                        if (name.includes(filter)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Optional: Hide empty cards
                    document.querySelectorAll('#usersGrid > div').forEach(card => {
                        let visibleRows = card.querySelectorAll('.user-row:not([style*="display: none"])');
                        card.style.display = visibleRows.length > 0 ? '' : 'none';
                    });
                });
            }
        });
    </script>
</x-app-layout>
