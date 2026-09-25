<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Nama | Kiosk KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');</style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background:#EEF2F1;">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl border-2" style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;">
        <h1 class="text-2xl font-bold mb-8 text-center" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Pilih Nama Anda</h1>
        
        <div class="grid grid-cols-1 gap-3 max-h-96 overflow-y-auto pr-2">
            @foreach($users as $user)
                <a href="{{ route('kiosk.pin', $user) }}" 
                   class="block p-3 text-md font-semibold rounded-lg border-2 text-center transition-all hover:-translate-y-0.5"
                   style="border-color:#16302E; background:#FFFFFF; color:#16302E; box-shadow:2px 2px 0px 0px #16302E;">
                    {{ $user->name }}
                </a>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('kiosk.department') }}" class="text-sm font-medium" style="color:#5B6B68;">← Kembali</a>
        </div>
    </div>
</body>
</html>