<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Divisi | KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function redirectToDepartment(select) {
            if (select.value) {
                window.location.href = select.value;
            }
        }
    </script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-sm w-full text-center">
        <h1 class="text-2xl font-semibold text-slate-900 mb-8 tracking-tight">Pilih Divisi Anda</h1>
        
        <select 
            onchange="redirectToDepartment(this)" 
            class="w-full p-4 text-lg border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700 outline-none transition-all"
        >
            <option value="">-- Pilih Divisi --</option>
            @foreach($departments as $dept)
                <option value="{{ route('kiosk.user', $dept) }}">
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </div>
</body>
</html>