<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Super Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-300 font-sans antialiased flex h-screen overflow-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Sidebar -->
    <aside class="w-64 bg-black text-white flex flex-col hidden md:flex absolute md:relative z-20 h-full transition-transform duration-300 transform md:translate-x-0" :class="mobileMenuOpen ? 'translate-x-0 !flex' : '-translate-x-full'">
        <div class="h-16 flex items-center justify-between px-6 font-bold text-2xl border-b border-zinc-800 tracking-tight">
            GymOS
            <button class="md:hidden text-white" @click="mobileMenuOpen = false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-red-900/40 hover:text-white transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-red-900/60 text-red-400 border-r-4 border-red-500 font-semibold shadow-inner' : '' }}">Dashboard</a>
            <a href="{{ route('superadmin.gyms.index') }}" class="block px-4 py-3 rounded-lg hover:bg-red-900/40 hover:text-white transition {{ request()->routeIs('superadmin.gyms.*') ? 'bg-red-900/60 text-red-400 border-r-4 border-red-500 font-semibold shadow-inner' : '' }}">Gyms</a>
            <a href="{{ route('superadmin.gym-admins.index') }}" class="block px-4 py-3 rounded-lg hover:bg-red-900/40 hover:text-white transition {{ request()->routeIs('superadmin.gym-admins.*') ? 'bg-red-900/60 text-red-400 border-r-4 border-red-500 font-semibold shadow-inner' : '' }}">Gym Admins</a>
            <a href="{{ route('superadmin.revenue') }}" class="block px-4 py-3 rounded-lg hover:bg-red-900/40 hover:text-white transition {{ request()->routeIs('superadmin.revenue') ? 'bg-red-900/60 text-red-400 border-r-4 border-red-500 font-semibold shadow-inner' : '' }}">Revenue</a>
        </nav>
        <div class="p-4 border-t border-zinc-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 shadow text-white py-2 rounded-lg font-semibold transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-black bg-opacity-50 z-10 md:hidden" @click="mobileMenuOpen = false" x-cloak></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">
        <!-- Top Header -->
        <header class="h-16 bg-zinc-900 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.5)] flex items-center justify-between px-6 md:justify-end border-b border-zinc-800 z-10 relative">
            <div class="font-bold text-xl text-primary md:hidden">GymOS</div>
            <div class="flex items-center space-x-6">
                <div class="hidden md:flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-900/40 text-primary flex items-center justify-center font-bold text-sm">
                        SA
                    </div>
                    <span class="text-sm font-semibold text-zinc-300">Super Admin</span>
                </div>
                <button class="text-zinc-400 hover:text-primary transition md:hidden focus:outline-none" @click="mobileMenuOpen = true">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </header>

        <!-- Main section -->
        <main class="flex-1 overflow-x-auto overflow-y-auto bg-zinc-950 p-4 md:p-8">
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

    @stack('scripts')
</body>
</html>
