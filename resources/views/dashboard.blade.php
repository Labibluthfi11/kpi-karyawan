<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Penilaian KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Halo, {{ Auth::user()->name }}</h3>
                <p class="mb-6 text-gray-600">Gunakan menu di bawah ini untuk melakukan penilaian kinerja.</p>
                
                <a href="{{ route('kpi.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    Mulai Penilaian
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
