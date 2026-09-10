<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Nama | KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function redirectToUser(select) {
            if (select.value) {
                window.location.href = select.value;
            }
        }
    </script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-sm w-full text-center">
        <h1 class="text-2xl font-semibold text-slate-900 mb-8 tracking-tight">Pilih Nama Anda</h1>
        
        <select 
            onchange="redirectToUser(this)" 
            class="w-full p-4 text-lg border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700 outline-none transition-all"
        >
            <option value="">-- Pilih Nama Anda --</option>
            @foreach($users as $user)
                <option value="{{ route('kiosk.pin', $user) }}">
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
</body>
</html>