<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penilaian KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Daftar Karyawan untuk Dinilai</h1>
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        <div class="bg-white shadow rounded overflow-hidden">
            @foreach($targetUsers as $user)
                <div class="p-4 border-b flex justify-between items-center">
                    <span>{{ $user->name }} ({{ $user->role->name }})</span>
                    <a href="{{ route('kpi.form', $user) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Nilai</a>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
