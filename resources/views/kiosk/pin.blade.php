<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input PIN | KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xs w-full text-center">
        <h1 class="text-xl font-medium text-slate-900 mb-12 tracking-tight">Masukkan PIN</h1>
        
        @if($errors->any())
            <p class="text-red-500 mb-4">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('kiosk.verify', $user) }}" method="POST">
            @csrf
            <input type="password" name="pin" maxlength="4" class="w-full text-center text-2xl py-4 border-b-2 border-slate-300 focus:border-black outline-none transition" placeholder="****" required autofocus>
            <button type="submit" class="w-full mt-8 bg-black text-white py-3 rounded-lg font-medium">Lanjut</button>
        </form>
    </div>
</body>
</html>
