<nav x-data="{ open: false, userOpen: false }" style="background:#16302E;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                        <div class="flex gap-0.5 items-end h-5">
                            <div class="w-1.5 rounded-sm" style="height:60%; background:#75B8C0;"></div>
                            <div class="w-1.5 rounded-sm" style="height:100%; background:#F4A261;"></div>
                            <div class="w-1.5 rounded-sm" style="height:80%; background:#75B8C0;"></div>
                        </div>
                        <span style="font-family:'Space Grotesk', sans-serif;" class="text-white font-semibold text-lg tracking-tight">KPI System</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:gap-1">
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors border-b-2
                       {{ request()->routeIs('admin.dashboard') ? 'text-white border-transparent' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}"
                       @if(request()->routeIs('admin.dashboard')) style="background:rgba(244,162,97,0.18); border-color:#F4A261;" @endif>
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('admin.departments.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors border-b-2
                       {{ request()->routeIs('admin.departments.*') ? 'text-white border-transparent' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}"
                       @if(request()->routeIs('admin.departments.*')) style="background:rgba(244,162,97,0.18); border-color:#F4A261;" @endif>
                        {{ __('Divisi') }}
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors border-b-2
                       {{ request()->routeIs('admin.users.*') ? 'text-white border-transparent' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}"
                       @if(request()->routeIs('admin.users.*')) style="background:rgba(244,162,97,0.18); border-color:#F4A261;" @endif>
                        {{ __('Karyawan') }}
                    </a>
                    <a href="{{ route('admin.periods.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors border-b-2
                       {{ request()->routeIs('admin.periods.*') ? 'text-white border-transparent' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}"
                       @if(request()->routeIs('admin.periods.*')) style="background:rgba(244,162,97,0.18); border-color:#F4A261;" @endif>
                        {{ __('Periode') }}
                    </a>
                    <a href="{{ route('admin.results.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors border-b-2
                       {{ request()->routeIs('admin.results.*') ? 'text-white border-transparent' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}"
                       @if(request()->routeIs('admin.results.*')) style="background:rgba(244,162,97,0.18); border-color:#F4A261;" @endif>
                        {{ __('Hasil Penilaian') }}
                    </a>
                    <a href="{{ route('admin.assignments.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors border-b-2
                       {{ request()->routeIs('admin.assignments.*') ? 'text-white border-transparent' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}"
                       @if(request()->routeIs('admin.assignments.*')) style="background:rgba(244,162,97,0.18); border-color:#F4A261;" @endif>
                        {{ __('Mapping Penilaian') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:block relative" @click.away="userOpen = false">
                <button @click="userOpen = !userOpen" class="flex items-center gap-2.5 pl-1 pr-3 py-1.5 rounded-full hover:bg-white/5 transition-colors focus:outline-none">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm text-white" style="background:#75B8C0; font-family:'Space Grotesk', sans-serif;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <span class="text-sm text-white/90 font-medium">{{ Auth::user()->name }}</span>
                    <svg class="w-3.5 h-3.5 text-white/50 fill-current" :class="{'rotate-180': userOpen}" style="transition:transform .15s" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="userOpen" x-cloak x-transition
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl border-2 overflow-hidden z-50"
                     style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-[#16302E] hover:bg-[#F1F6F5]">
                        {{ __('Profile') }}
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="block px-4 py-2.5 text-sm text-[#16302E] hover:bg-[#F1F6F5] border-t cursor-pointer" style="border-color:#EAEAEA;">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/5 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t" style="border-color:rgba(255,255,255,0.1);">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-white/70 hover:bg-white/5' }}"
               @if(request()->routeIs('admin.dashboard')) style="background:rgba(244,162,97,0.18);" @endif>
                {{ __('Dashboard') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t px-4" style="border-color:rgba(255,255,255,0.1);">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-semibold text-sm text-white" style="background:#75B8C0; font-family:'Space Grotesk', sans-serif;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white/50">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-1 py-2 text-sm text-white/70">
                    {{ __('Profile') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-1 py-2 text-sm text-white/70 cursor-pointer">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
