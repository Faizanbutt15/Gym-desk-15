<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Gym Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased flex h-screen overflow-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Sidebar -->
    <aside class="w-64 bg-black text-white flex flex-col hidden md:flex absolute md:relative z-20 h-full transition-transform duration-300 transform md:translate-x-0" :class="mobileMenuOpen ? 'translate-x-0 !flex' : '-translate-x-full'">
        <div class="h-16 flex items-center justify-between px-4 font-bold text-lg border-b border-blue-800 tracking-tight whitespace-nowrap overflow-hidden text-ellipsis">
            {{ \Illuminate\Support\Str::limit(auth()->user()->gym->name ?? 'Gym Panel', 18) }}
            <button class="md:hidden text-white" @click="mobileMenuOpen = false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('gym.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('gym.dashboard') ? 'bg-blue-800 shadow-inner' : '' }}">Dashboard</a>
            <a href="{{ route('members.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('members.*') ? 'bg-blue-800 shadow-inner' : '' }}">Members</a>
            <a href="{{ route('expiring-soon') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('expiring-soon') ? 'bg-blue-800 shadow-inner' : '' }}">Expiring Soon</a>
            <a href="{{ route('expired') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('expired') ? 'bg-blue-800 shadow-inner' : '' }}">Expired</a>
            <a href="{{ route('inactive-members') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('inactive-members') ? 'bg-blue-800 shadow-inner' : '' }}">Inactive</a>
            <a href="{{ route('staff.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('staff.*') ? 'bg-blue-800 shadow-inner' : '' }}">Staff</a>
            <a href="{{ route('attendance.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('attendance.*') ? 'bg-blue-800 shadow-inner' : '' }}">Attendance</a>
            <a href="{{ route('revenue.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('revenue.*') ? 'bg-blue-800 shadow-inner' : '' }}">Revenue</a>
        </nav>
        <div class="p-4 border-t border-blue-800">
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
        <header class="h-16 bg-white shadow-[0_4px_20px_-10px_rgba(0,0,0,0.1)] flex items-center justify-between px-6 md:justify-end border-b border-gray-100 z-10 relative">
            <div class="font-bold text-xl text-primary md:hidden">{{ \Illuminate\Support\Str::limit(auth()->user()->gym->name ?? 'Gym Panel', 15) }}</div>
            <div class="flex items-center space-x-6">
                <div class="hidden md:flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</span>
                </div>
                <button class="text-gray-600 hover:text-primary transition md:hidden focus:outline-none" @click="mobileMenuOpen = true">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </header>

        <!-- Main section -->
        <main class="flex-1 overflow-x-auto overflow-y-auto bg-gray-50 p-4 md:p-8">
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
