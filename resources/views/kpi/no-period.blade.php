<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Tutup | Kiosk KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');</style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background:#EEF2F1;">
    <div class="max-w-sm w-full bg-white p-8 rounded-2xl border-2 text-center" style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;">
        <div class="text-6xl mb-6">⚠️</div>
        <h1 class="text-2xl font-bold mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Penilaian Tutup</h1>
        <p class="mb-8" style="color:#5B6B68;">Tidak ada periode penilaian yang aktif saat ini.</p>
        <a href="{{ route('kiosk.department') }}" 
           class="block w-full p-4 text-lg font-bold text-white rounded-xl border-2 transition-all hover:-translate-y-0.5"
           style="background:#16302E; border-color:#16302E; box-shadow:3px 3px 0px 0px #F4A261;">
            Kembali
        </a>
    </div>
</body>
</html>