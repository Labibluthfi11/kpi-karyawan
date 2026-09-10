<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 p-8" x-data="{ showModal: false }">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Penilaian untuk {{ $user->name }}</h1>
        <form @submit.prevent="showModal = true; $refs.form.submit()" x-ref="form" action="{{ route('kpi.store', $user) }}" method="POST">
            @csrf
            @foreach($questions as $question)
                <div class="mb-4">
                    <label class="block mb-1">{{ $question->question_text }} ({{ $question->category }})</label>
                    <select name="scores[{{ $question->id }}]" class="w-full border p-2 rounded" required>
                        <option value="1">Engga Banget</option>
                        <option value="2">Engga </option>
                        <option value="3">Biasa Aja</option>
                        <option value="4">Ya</option>
                        <option value="5">Ya Ya Saya Stecu</option>
                    </select>
                </div>
            @endforeach
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan Penilaian</button>
        </form>
    </div>

    <!-- Animated Success Modal -->
    <div x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-8 rounded-lg shadow-xl text-center transform transition-all">
            <div class="text-green-500 text-5xl mb-4">✨</div>
            <h2 class="text-2xl font-bold mb-2">Penilaian Selesai!</h2>
            <p class="text-gray-600">Terima kasih! Silahkan lanjut kerja kembali.</p>
        </div>
    </div>
</body>
</html>
