<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full text-center">
        <!-- Judul -->
        <h1 class="text-3xl font-bold text-gray-900 mb-2">KPI System</h1>
        <p class="text-gray-500 mb-10">Jembatan pengembangan performa karyawanmu!</p>

        <!-- Tombol Sejajar -->
        <div class="flex justify-center gap-4">
            <a href="{{ route('kiosk.department') }}" class="px-8 py-3 bg-[#75B8C0] hover:bg-[#60A1A9] text-white font-medium rounded-lg shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">
                Login Karyawan
            </a>
            <a href="{{ route('login') }}" class="px-8 py-3 bg-[#F4A261] hover:bg-[#E08E4E] text-white font-medium rounded-lg shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">
                Login Admin
            </a>
        </div>
    </div>

</body>
</html>
