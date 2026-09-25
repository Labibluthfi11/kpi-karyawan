<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - KPI System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .hard-shadow { box-shadow: 5px 5px 0px 0px #16302E; }
        .input-field {
            border: 2px solid #16302E;
            border-radius: 0.5rem;
            padding: 0.65rem 0.9rem;
            width: 100%;
            transition: box-shadow .15s ease, transform .15s ease;
            background: #fff;
        }
        .input-field:focus {
            outline: none;
            box-shadow: 3px 3px 0px 0px #16302E;
            transform: translate(-1px, -1px);
        }
        .btn-submit {
            background: #F4A261;
            transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
        }
        .btn-submit:hover {
            background: #E08E4E;
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #16302E;
        }
        input[type="checkbox"] { accent-color: #F4A261; }
    </style>
</head>
<body class="min-h-screen relative overflow-hidden" style="background: linear-gradient(180deg, #F6FAF9 0%, #F1F6F0 60%, #EFF3EC 100%);">

    <!-- Dekorasi bar chart, versi lebih kecil di pojok -->
    <div class="absolute bottom-0 left-0 right-0 flex items-end justify-center gap-3 md:gap-5 opacity-40 pointer-events-none" style="height: 26vh;">
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
    <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(246,250,249,0) 0%, rgba(246,250,249,0.85) 60%, #F6FAF9 100%);"></div>

    <!-- Konten -->
    <div class="relative min-h-screen flex items-center justify-center p-6">
        <div class="max-w-sm w-full">

            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-semibold mb-2" style="color:#16302E;">Login Admin</h1>
                <p class="text-[#5B6B68] text-sm">Masuk untuk kelola data dan laporan KPI tim</p>
            </div>

            <div class="bg-white rounded-xl border-2 hard-shadow p-6" style="border-color:#16302E;">

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mb-4 px-4 py-2 rounded-lg text-sm font-medium" style="background:#E8F4E0; color:#2F5B1F; border:2px solid #2F5B1F;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email Address --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Email</label>
                        <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium mb-1.5" style="color:#16302E;">Password</label>
                        <input id="password" class="input-field" type="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-6">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded" name="remember">
                            <span class="ms-2 text-sm text-[#5B6B68]">Ingat saya</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-[#5B6B68] hover:text-[#16302E] underline" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif

                        <button type="submit" class="btn-submit ms-auto px-6 py-2.5 rounded-lg text-white font-medium border-2" style="border-color:#16302E;">
                            Login
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
