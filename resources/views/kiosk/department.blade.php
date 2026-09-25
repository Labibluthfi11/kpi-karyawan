<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Divisi | Kiosk KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');</style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background:#EEF2F1;">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl border-2" style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;">
        <h1 class="text-2xl font-bold mb-8 text-center" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Pilih Divisi Anda</h1>
        
        <div class="grid grid-cols-1 gap-4">
            @foreach($departments as $dept)
                <a href="{{ route('kiosk.user', $dept) }}" 
                   class="block p-4 text-lg font-semibold rounded-xl border-2 text-center transition-all hover:-translate-y-0.5"
                   style="border-color:#16302E; background:#F1F6F5; color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                    {{ $dept->name }}
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>