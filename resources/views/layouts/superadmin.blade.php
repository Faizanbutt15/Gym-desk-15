<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gymdesk15 - Super Admin</title>
    {{-- Theme init: runs before body renders to prevent flash --}}
    <script>
        (function() {
            var theme = localStorage.getItem('theme');
            if (theme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-700 dark:text-zinc-300 font-sans antialiased flex h-screen overflow-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-black text-zinc-800 dark:text-white flex flex-col hidden md:flex absolute md:relative z-20 h-full border-r border-zinc-200 dark:border-zinc-800 transition-transform duration-300 transform md:translate-x-0" :class="mobileMenuOpen ? 'translate-x-0 !flex' : '-translate-x-full'">
        <div class="h-16 flex items-center justify-between px-6 font-bold text-2xl border-b border-zinc-200 dark:border-zinc-800 tracking-tight text-zinc-900 dark:text-white">
            <span><span class="text-red-500">Gym</span>desk-15</span>
            <button class="md:hidden text-zinc-500 dark:text-white" @click="mobileMenuOpen = false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}"
               class="block px-4 py-3 rounded-xl transition-all text-sm font-medium
                      {{ request()->routeIs('superadmin.dashboard') ? 'bg-red-50 dark:bg-red-900/60 text-red-600 dark:text-red-400 border-r-4 border-red-500 font-semibold' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-red-900/40 hover:text-zinc-900 dark:hover:text-white' }}">
                Dashboard
            </a>
            <a href="{{ route('superadmin.gyms.index') }}"
               class="block px-4 py-3 rounded-xl transition-all text-sm font-medium
                      {{ request()->routeIs('superadmin.gyms.*') ? 'bg-red-50 dark:bg-red-900/60 text-red-600 dark:text-red-400 border-r-4 border-red-500 font-semibold' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-red-900/40 hover:text-zinc-900 dark:hover:text-white' }}">
                Gyms
            </a>
            <a href="{{ route('superadmin.gym-admins.index') }}"
               class="block px-4 py-3 rounded-xl transition-all text-sm font-medium
                      {{ request()->routeIs('superadmin.gym-admins.*') ? 'bg-red-50 dark:bg-red-900/60 text-red-600 dark:text-red-400 border-r-4 border-red-500 font-semibold' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-red-900/40 hover:text-zinc-900 dark:hover:text-white' }}">
                Gym Admins
            </a>
            <a href="{{ route('superadmin.revenue') }}"
               class="block px-4 py-3 rounded-xl transition-all text-sm font-medium
                      {{ request()->routeIs('superadmin.revenue') ? 'bg-red-50 dark:bg-red-900/60 text-red-600 dark:text-red-400 border-r-4 border-red-500 font-semibold' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-red-900/40 hover:text-zinc-900 dark:hover:text-white' }}">
                Revenue
            </a>
        </nav>
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 shadow text-white py-2 rounded-xl font-semibold transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-black bg-opacity-50 z-10 md:hidden" @click="mobileMenuOpen = false" x-cloak></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">
        <!-- Top Header -->
        <header class="h-16 bg-white dark:bg-zinc-900 flex items-center justify-between px-6 border-b border-zinc-200 dark:border-zinc-800 z-10 relative">
            <div class="font-bold text-xl text-red-500 md:hidden">Gymdesk15</div>
            <div class="flex items-center space-x-3 md:ml-auto">
                <div class="hidden md:flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-50 dark:bg-red-900/40 text-red-500 dark:text-red-400 flex items-center justify-center font-bold text-sm">
                        SA
                    </div>
                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Super Admin</span>
                </div>

                {{-- Dark / Light Mode Toggle --}}
                <button id="theme-toggle"
                        onclick="toggleTheme()"
                        class="w-9 h-9 rounded-xl border border-zinc-200 dark:border-zinc-700/60 bg-zinc-50 dark:bg-zinc-800/60 flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-600 transition-all focus:outline-none"
                        title="Toggle theme">
                    <i id="theme-icon-sun" class="ph-bold ph-sun" style="font-size:18px;"></i>
                    <i id="theme-icon-moon" class="ph-bold ph-moon hidden" style="font-size:18px;"></i>
                </button>

                <button class="text-zinc-500 dark:text-zinc-400 hover:text-red-500 transition md:hidden focus:outline-none" @click="mobileMenuOpen = true">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </header>

        <!-- Main section -->
        <main class="flex-1 overflow-x-auto overflow-y-auto bg-zinc-50 dark:bg-zinc-950 p-4 md:p-8">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: "{{ session('success') }}",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: "{{ $errors->first() }}",
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                        });
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleTheme() {
            var html = document.documentElement;
            var sun  = document.getElementById('theme-icon-sun');
            var moon = document.getElementById('theme-icon-moon');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                sun.classList.add('hidden');
                moon.classList.remove('hidden');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                moon.classList.add('hidden');
                sun.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var sun  = document.getElementById('theme-icon-sun');
            var moon = document.getElementById('theme-icon-moon');
            if (!document.documentElement.classList.contains('dark')) {
                sun.classList.add('hidden');
                moon.classList.remove('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
