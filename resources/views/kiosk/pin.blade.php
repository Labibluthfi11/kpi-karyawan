<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input PIN | Kiosk KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');</style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background:#EEF2F1;">
    <div class="max-w-xs w-full bg-white p-8 rounded-2xl border-2 text-center" style="border-color:#16302E; box-shadow:6px 6px 0px 0px #16302E;">
        <h1 class="text-xl font-bold mb-8" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">Masukkan PIN</h1>
        
        @if($errors->any())
            <p class="text-red-600 font-semibold mb-4 text-sm">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('kiosk.verify', $user) }}" method="POST">
            @csrf
            <input type="password" name="pin" maxlength="4" 
                   class="w-full text-center text-3xl py-4 border-2 rounded-xl outline-none transition" 
                   style="border-color:#16302E; font-family:'Space Grotesk', sans-serif;" 
                   placeholder="****" required autofocus>
            
            <button type="submit" 
                    class="w-full mt-8 font-bold py-3 rounded-lg border-2 text-white transition-all hover:-translate-y-0.5" 
                    style="background:#16302E; border-color:#16302E; box-shadow:3px 3px 0px 0px #16302E;">
                Lanjut
            </button>
        </form>
        
        <div class="mt-8">
            <a href="{{ route('kiosk.user', $user->department_id) }}" class="text-sm font-medium" style="color:#5B6B68;">← Kembali</a>
        </div>
    </div>
</body>
</html>