<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Nama | KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xs w-full text-center">
        <h1 class="text-xl font-medium text-slate-900 mb-12 tracking-tight">Pilih Nama Anda</h1>
        <div class="space-y-4">
            @foreach($users as $user)
                <a href="{{ route('kiosk.pin', $user) }}" class="block w-full text-slate-600 hover:text-black py-4 border-b border-slate-100 transition duration-200">
                    {{ $user->name }}
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
