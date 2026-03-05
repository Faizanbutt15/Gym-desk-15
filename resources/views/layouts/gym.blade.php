<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Gym Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: width 0.25s cubic-bezier(0.4,0,0.2,1); }
        .nav-label { transition: opacity 0.15s ease, width 0.2s ease; }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-300 font-sans antialiased flex h-screen overflow-hidden"
      x-data="{ sidebarOpen: true, mobileMenuOpen: false }">

    <!-- Sidebar -->
    <aside class="bg-black text-white flex flex-col h-full z-20 sidebar-transition flex-shrink-0 relative border-r border-zinc-800/60"
           :class="sidebarOpen ? 'w-60' : 'w-[68px]'"
           x-show="sidebarOpen || $store === undefined || true">

        <!-- Logo / Gym Name -->
        <div class="h-16 flex items-center border-b border-zinc-800/60 px-4 overflow-hidden whitespace-nowrap">
            <span class="text-red-500 text-xl font-black tracking-tight shrink-0">G</span>
            <span class="ml-1 font-bold text-white text-sm tracking-tight overflow-hidden transition-all duration-200"
                  :class="sidebarOpen ? 'opacity-100 max-w-full' : 'opacity-0 max-w-0'">
                {{ \Illuminate\Support\Str::limit(auth()->user()->gym->name ?? 'Gym Panel', 16) }}
            </span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden space-y-0.5 px-2">

            @php
                $navItems = [
                    ['route' => 'gym.dashboard',    'match' => 'gym.dashboard',  'icon' => 'ph-squares-four',    'label' => 'Dashboard'],
                    ['route' => 'members.index',     'match' => 'members.*',      'icon' => 'ph-users',           'label' => 'Members'],
                    ['route' => 'expiring-soon',     'match' => 'expiring-soon',  'icon' => 'ph-clock-countdown', 'label' => 'Expiring Soon'],
                    ['route' => 'expired',           'match' => 'expired',        'icon' => 'ph-warning-circle',  'label' => 'Expired'],
                    ['route' => 'inactive-members',  'match' => 'inactive-members','icon' => 'ph-prohibit',       'label' => 'Inactive'],
                    ['route' => 'staff.index',       'match' => 'staff.*',        'icon' => 'ph-briefcase',       'label' => 'Staff'],
                    ['route' => 'attendance.index',  'match' => 'attendance.*',   'icon' => 'ph-clipboard-text',  'label' => 'Attendance'],
                    ['route' => 'revenue.index',     'match' => 'revenue.*',      'icon' => 'ph-chart-line-up',   'label' => 'Revenue'],
                ];
            @endphp

            @foreach($navItems as $item)
                @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 group relative overflow-hidden
                          {{ $active ? 'bg-red-900/50 text-red-400 font-semibold' : 'text-zinc-400 hover:bg-zinc-800/70 hover:text-white' }}"
                   :class="sidebarOpen ? '' : 'justify-center px-0'"
                   :title="sidebarOpen ? '' : '{{ $item['label'] }}'">

                    @if($active)
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-[3px] bg-red-500 rounded-r-full"></span>
                    @endif

                    <i class="ph-bold {{ $item['icon'] }} text-[18px] shrink-0 {{ $active ? 'text-red-400' : '' }}"></i>
                    <span class="text-sm overflow-hidden whitespace-nowrap nav-label"
                          :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        <!-- Logout -->
        <div class="p-3 border-t border-zinc-800/60">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-red-600/20 hover:bg-red-600/40 text-red-400 hover:text-red-300 transition-all font-semibold"
                        :class="sidebarOpen ? '' : 'justify-center px-0'">
                    <i class="ph-bold ph-sign-out text-[18px] shrink-0"></i>
                    <span class="text-sm overflow-hidden whitespace-nowrap nav-label"
                          :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">
                        Logout
                    </span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-black bg-opacity-60 z-10 md:hidden"
         @click="mobileMenuOpen = false" x-cloak></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full relative min-w-0">

        <!-- Top Header -->
        <header class="h-16 bg-zinc-900 flex items-center justify-between px-5 border-b border-zinc-800 z-10 relative shrink-0">
            <!-- Left: hamburger -->
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="w-9 h-9 rounded-xl border border-zinc-700/60 bg-zinc-800/60 flex items-center justify-center text-zinc-400 hover:text-white hover:border-zinc-600 transition-all focus:outline-none">
                    <i class="ph-bold" :class="sidebarOpen ? 'ph-sidebar-simple' : 'ph-list'" style="font-size:18px;"></i>
                </button>
                <span class="text-sm font-semibold text-zinc-400 hidden md:block">
                    {{ \Illuminate\Support\Str::limit(auth()->user()->gym->name ?? 'Gym Panel', 20) }}
                </span>
            </div>

            <!-- Right: user info -->
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-red-900/50 text-red-400 flex items-center justify-center font-bold text-sm border border-red-900/60">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-sm font-semibold text-zinc-300 hidden md:block">{{ auth()->user()->name }}</span>
            </div>
        </header>

        <!-- Main section -->
        <main class="flex-1 overflow-x-auto overflow-y-auto bg-zinc-950 p-4 md:p-8">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            toast: true, position: 'top-end', icon: 'success',
                            title: "{{ session('success') }}", showConfirmButton: false,
                            timer: 3000, timerProgressBar: true,
                        });
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            toast: true, position: 'top-end', icon: 'error',
                            title: "{{ $errors->first() }}", showConfirmButton: false,
                            timer: 4000, timerProgressBar: true,
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
