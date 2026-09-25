<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Mapping Penilaian
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        search: '', 
        statusFilter: 'Semua',
        assignments: {{ json_encode($assignments) }}
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Summary Bar -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @php
                    $total = $assignments->count();
                    $completed = $assignments->where('status', 'completed')->count();
                    $pending = $total - $completed;
                @endphp
                <div class="bg-white p-4 rounded-xl border-2 flex justify-between items-center" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <span class="text-sm font-bold text-[#16302E]">Total: {{ $total }}</span>
                </div>
                <div class="bg-white p-4 rounded-xl border-2 flex justify-between items-center" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <span class="text-sm font-bold text-[#2F5B1F]">Selesai: {{ $completed }}</span>
                </div>
                <div class="bg-white p-4 rounded-xl border-2 flex justify-between items-center" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <span class="text-sm font-bold text-[#E08E4E]">Pending: {{ $pending }}</span>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="flex flex-col gap-4 mb-6">
                <input type="text" x-model="search" placeholder="Cari penilai atau yang dinilai..."
                       class="border-2 rounded-lg px-4 py-2.5 w-full transition-all focus:outline-none"
                       style="border-color:#16302E;">
                
                <div class="flex gap-2">
                    @foreach(['Semua', 'Completed', 'Pending'] as $status)
                        <button x-on:click="statusFilter = '{{ $status }}'"
                                :class="statusFilter === '{{ $status }}' ? 'text-white' : 'text-[#16302E] bg-white'"
                                class="px-4 py-2 rounded-lg border-2 font-medium transition-all"
                                style="border-color:#16302E;"
                                :style="statusFilter === '{{ $status }}' ? 'background:#16302E;' : ''">
                            {{ $status }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Grid of Assignments -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="assignmentsGrid">
                <template x-for="assign in assignments" :key="assign.id">
                    <div class="bg-white rounded-xl border-2 p-5 flex flex-col justify-between assignment-card"
                         x-show="(statusFilter === 'Semua' || (statusFilter === 'Completed' ? assign.status === 'completed' : assign.status !== 'completed')) && (assign.evaluator.name.toLowerCase().includes(search.toLowerCase()) || assign.evaluatee.name.toLowerCase().includes(search.toLowerCase()))"
                         style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full" 
                                      :class="assign.status === 'completed' ? 'bg-[#E8F4E0] text-[#2F5B1F]' : 'bg-[#FDF3E7] text-[#E08E4E]'"
                                      x-text="assign.status.charAt(0).toUpperCase() + assign.status.slice(1)">
                                </span>
                            </div>
                            <div class="mb-4">
                                <div class="text-xs text-[#5B6B68]">Penilai</div>
                                <div class="font-semibold text-[#16302E]" x-text="assign.evaluator.name"></div>
                            </div>
                            <div class="mb-4">
                                <div class="text-xs text-[#5B6B68]">Dinilai</div>
                                <div class="font-semibold text-[#16302E]" x-text="assign.evaluatee.name"></div>
                            </div>
                        </div>

                        <div class="border-t pt-4 mt-2" style="border-color:#EEF2F1;">
                            <button type="button" 
                                    class="text-sm font-semibold text-red-600 hover:text-red-800"
                                    x-on:click="$dispatch('open-delete-modal', `{{ route('admin.assignments.destroy', 0) }}`.replace('0', assign.id))">
                                Hapus
                            </button>
                        </div>
                    </div>
                </template>
                
                <!-- Empty Search State -->
                <div x-show="!assignments.some(a => (statusFilter === 'Semua' || (statusFilter === 'Completed' ? a.status === 'completed' : a.status !== 'completed')) && (a.evaluator.name.toLowerCase().includes(search.toLowerCase()) || a.evaluatee.name.toLowerCase().includes(search.toLowerCase())))"
                     class="col-span-full py-10 text-center text-[#5B6B68]">
                    Penugasan tidak ditemukan.
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Delete Modal -->
    <div x-data="{ show: false }" 
         x-on:open-delete-modal.window="show = true; document.getElementById('delete-assignment-form').action = $event.detail;"
         x-on:close-modal.window="show = false"
         x-show="show" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display: none;">
         
        <div x-on:click="show = false" class="fixed inset-0 bg-[#16302E] opacity-50"></div>

        <div class="bg-white p-6 rounded-xl border-2 z-10 w-full max-w-lg" 
             style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;"
             x-show="show">
             
            <h2 class="text-xl font-bold mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                Hapus Penugasan?
            </h2>
            <p class="mb-6 text-[#5B6B68]">Apakah anda yakin ingin menghapus penugasan penilaian ini?</p>
            
            <form id="delete-assignment-form" method="POST" class="flex justify-end gap-3">
                @csrf @method('DELETE')
                <button type="button" x-on:click="show = false" class="font-medium py-2 px-5 rounded-lg border-2" style="border-color:#16302E; color:#16302E;">Batal</button>
                <button type="submit" class="font-medium py-2 px-5 rounded-lg text-white border-2" style="background:#D97757; border-color:#16302E;">Oke</button>
            </form>
        </div>
    </div>
</x-app-layout>
