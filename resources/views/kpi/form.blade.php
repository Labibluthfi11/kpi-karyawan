<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian | Kiosk KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');</style>
</head>
<body class="min-h-screen p-4 md:p-6" style="background:#EEF2F1;" x-data="{ showConfirmModal: false }">
    <div class="max-w-2xl mx-auto w-full">
        <h1 class="text-2xl font-bold mb-6 text-center" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
            Penilaian: {{ $user->name }}
        </h1>

        <form action="{{ route('kpi.store', $user) }}" method="POST" class="space-y-6" id="kpiForm">
            @csrf
            <input type="hidden" name="status" id="formStatus" value="completed">

            @php
                $groupedQuestions = $questions->groupBy('category');
            @endphp

            @foreach($groupedQuestions as $category => $categoryQuestions)
                <div class="bg-white p-6 rounded-2xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <h2 class="text-lg font-bold mb-4 pb-2 border-b-2" style="font-family:'Space Grotesk', sans-serif; color:#16302E; border-color:#EEF2F1;">{{ $category }}</h2>
                    <div class="space-y-6">
                        @foreach($categoryQuestions as $question)
                            <div>
                                <label class="block font-semibold mb-3" style="color:#16302E;">{{ $question->question_text }}</label>
                                <div class="grid grid-cols-5 gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="scores[{{ $question->id }}]" value="{{ $i }}" class="peer sr-only" required {{ isset($existingScores[$question->id]) && $existingScores[$question->id] == $i ? 'checked' : '' }}>
                                            <div class="p-2 text-center rounded-lg border-2 font-bold transition-all 
                                                        select-option-box">
                                                {{ $i }}
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                                <style>
                                    .select-option-box {
                                        border-color: #16302E;
                                        background: #FFFFFF;
                                        color: #16302E;
                                    }
                                    input[type="radio"]:checked + .select-option-box {
                                        background-color: #16302E !important;
                                        color: #FFFFFF !important;
                                    }
                                </style>
                                <div class="flex justify-between text-[10px] uppercase font-bold mt-1 px-1 mb-4" style="color:#5B6B68;">
                                    <span>Sangat Kureng</span>
                                    <span>Kureng</span>
                                    <span>Cukup</span>
                                    <span>Bagus</span>
                                    <span>Sangat Bagus</span>
                                </div>
                                <!-- Input Catatan -->
                                <textarea name="notes[{{ $question->id }}]" 
                                          class="w-full border-2 rounded-lg p-2 mt-2 text-sm focus:outline-none" 
                                          style="border-color:#EEF2F1;" 
                                          placeholder="Catatan (opsional)...">{{ $existingNotes[$question->id] ?? '' }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- General Note -->
            <div class="bg-white p-6 rounded-2xl border-2" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                <label class="block font-bold mb-3" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
                    Catatan Umum untuk {{ $user->name }}
                </label>
                <textarea name="general_note" 
                          class="w-full border-2 rounded-lg p-3 text-sm focus:outline-none" 
                          style="border-color:#EEF2F1;" 
                          rows="3"
                          placeholder="Tuliskan catatan atau masukan umum untuk karyawan ini (opsional)...">{{ $existingAssessment->general_note ?? '' }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button type="submit" onclick="document.getElementById('formStatus').value='draft'"
                        class="w-full font-bold py-3 rounded-lg border-2 text-white transition-all hover:-translate-y-0.5"
                        style="background:#F4A261; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                    Simpan Draft
                </button>
                <button type="button" @click="showConfirmModal = true"
                        class="w-full font-bold py-3 rounded-lg border-2 text-white transition-all hover:-translate-y-0.5"
                        style="background:#16302E; border-color:#16302E; box-shadow:3px 3px 0px 0px #75B8C0;">
                    Kirim Penilaian
                </button>
            </div>
        </form>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
        <div class="bg-white p-8 rounded-2xl border-2 max-w-sm w-full text-center" style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;">
            <h2 class="text-xl font-bold mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Konfirmasi Penilaian</h2>
            <p class="mb-6" style="color:#5B6B68;">Apakah Anda yakin ingin menyelesaikan penilaian terhadap <strong>{{ $user->name }}</strong>? Jawaban tidak dapat diubah kembali setelah dikirim.</p>
            <div class="flex gap-4">
                <button @click="showConfirmModal = false" class="flex-1 py-2 font-bold rounded-lg border-2" style="border-color:#16302E; color:#16302E;">Batal</button>
                <button @click="document.getElementById('kpiForm').submit()" class="flex-1 py-2 font-bold rounded-lg text-white" style="background:#16302E;">Yakin, Kirim</button>
            </div>
        </div>
    </div>
</body>
</html>
