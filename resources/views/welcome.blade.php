<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .hard-shadow { box-shadow: 4px 4px 0px 0px #16302E; }
        .card-hover { transition: transform .15s ease, box-shadow .15s ease; }
        .card-hover:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0px 0px #16302E; }
    </style>
</head>
<body class="min-h-screen relative overflow-hidden" style="background: linear-gradient(180deg, #F6FAF9 0%, #F1F6F0 60%, #EFF3EC 100%);">

    <!-- Dekorasi bar chart naik -->
    <div class="absolute bottom-0 left-0 right-0 flex items-end justify-center gap-3 md:gap-5 opacity-90 pointer-events-none" style="height: 38vh;">
        <div class="w-8 md:w-12 rounded-t-md" style="height:22%; background:#B7DCE0;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:38%; background:#F4A261; opacity:.55;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:30%; background:#75B8C0;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:55%; background:#F4A261; opacity:.7;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:44%; background:#75B8C0;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:68%; background:#F4A261;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:50%; background:#75B8C0; opacity:.8;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:78%; background:#F4A261;"></div>
        <div class="w-8 md:w-12 rounded-t-md" style="height:60%; background:#75B8C0;"></div>
    </div>
    <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(246,250,249,0) 0%, rgba(246,250,249,0.75) 55%, #F6FAF9 100%);"></div>

    <!-- Konten -->
    <div class="relative min-h-screen flex items-center justify-center p-6">
        <div class="max-w-lg w-full text-center">

            <!-- Judul -->
            <h1 class="font-display text-4xl md:text-5xl font-semibold mb-3" style="color:#16302E;">
                KPI System
            </h1>
            <p class="text-[#5B6B68] mb-12 text-base">
                    Penilain Karyawan PT. ANSEL MUDA BERKARYA
            </p>

            <!-- Kartu Login -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">

                <a href="{{ route('kiosk.department') }}" class="card-hover hard-shadow group block rounded-xl border-2 p-5 bg-white" style="border-color:#16302E;">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-4" style="background:#75B8C0;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="font-display font-semibold text-lg mb-1" style="color:#16302E;">Login Karyawan</div>
                    <p class="text-sm text-[#5B6B68]">Absen dan lihat KPI harian lewat kiosk</p>
                </a>

                <a href="{{ route('login') }}" class="card-hover hard-shadow group block rounded-xl border-2 p-5 bg-white" style="border-color:#16302E;">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-4" style="background:#F4A261;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <div class="font-display font-semibold text-lg mb-1" style="color:#16302E;">Login Admin</div>
                    <p class="text-sm text-[#5B6B68]">Kelola data, penilaian, dan laporan tim</p>
                </a>

            </div>
        </div>
    </div>

</body>
</html>
