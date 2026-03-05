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
<body class="bg-zinc-950 text-zinc-300 font-sans antialiased"
      x-data="{ sidebarOpen: true, mobileMenuOpen: false }">

<div class="flex h-screen overflow-hidden">

    {{-- ═══ MOBILE OVERLAY ═══ --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/70 z-30 lg:hidden"
         @click="mobileMenuOpen = false" x-cloak></div>

    {{-- ═══ SIDEBAR ═══ --}}
    {{-- Mobile: fixed drawer sliding from left --}}
    {{-- Desktop: collapsible inline sidebar --}}
    <aside
        class="bg-black text-white flex flex-col h-full border-r border-zinc-800/60 z-40 flex-shrink-0
               fixed inset-y-0 left-0 lg:relative lg:translate-x-0 sidebar-transition"
        :class="{
            'translate-x-0': mobileMenuOpen,
            '-translate-x-full': !mobileMenuOpen,
            'w-60': sidebarOpen || !$el.classList.contains('lg:relative') ,
            'lg:w-60': sidebarOpen,
            'lg:w-[68px]': !sidebarOpen
        }"
        style="width: 240px"
        x-bind:style="window.innerWidth >= 1024
            ? (sidebarOpen ? 'width:240px' : 'width:68px')
            : 'width:240px'">

        {{-- Logo --}}
        <div class="h-16 flex items-center border-b border-zinc-800/60 px-4 overflow-hidden whitespace-nowrap shrink-0">
            <span class="text-red-500 text-xl font-black tracking-tight shrink-0">G</span>
            <span class="ml-1 font-bold text-white text-sm tracking-tight overflow-hidden transition-all duration-200"
                  x-bind:class="{ 'opacity-100 max-w-full': sidebarOpen || mobileMenuOpen, 'opacity-0 max-w-0 lg:hidden': !sidebarOpen && !mobileMenuOpen }">
                {{ \Illuminate\Support\Str::limit(auth()->user()->gym->name ?? 'Gym Panel', 16) }}
            </span>
            {{-- Mobile close button --}}
            <button @click="mobileMenuOpen = false" class="ml-auto lg:hidden text-zinc-400 hover:text-white">
                <i class="ph-bold ph-x" style="font-size:18px;"></i>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden space-y-0.5 px-2">
            @php
                $navItems = [
                    ['route' => 'gym.dashboard',    'match' => 'gym.dashboard',   'icon' => 'ph-squares-four',    'label' => 'Dashboard'],
                    ['route' => 'members.index',     'match' => 'members.*',       'icon' => 'ph-users',           'label' => 'Members'],
                    ['route' => 'expiring-soon',     'match' => 'expiring-soon',   'icon' => 'ph-clock-countdown', 'label' => 'Expiring Soon'],
                    ['route' => 'expired',           'match' => 'expired',         'icon' => 'ph-warning-circle',  'label' => 'Expired'],
                    ['route' => 'inactive-members',  'match' => 'inactive-members','icon' => 'ph-prohibit',        'label' => 'Inactive'],
                    ['route' => 'staff.index',       'match' => 'staff.*',         'icon' => 'ph-briefcase',       'label' => 'Staff'],
                    ['route' => 'attendance.index',  'match' => 'attendance.*',    'icon' => 'ph-clipboard-text',  'label' => 'Attendance'],
                ];
            @endphp
            @foreach($navItems as $item)
                @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 group relative overflow-hidden
                          {{ $active ? 'bg-red-900/50 text-red-400 font-semibold' : 'text-zinc-400 hover:bg-zinc-800/70 hover:text-white' }}"
                   x-bind:class="(sidebarOpen || mobileMenuOpen) ? '' : 'lg:justify-center lg:px-0'"
                   title="{{ $item['label'] }}">
                    @if($active)
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-[3px] bg-red-500 rounded-r-full"></span>
                    @endif
                    <i class="ph-bold {{ $item['icon'] }} text-[18px] shrink-0 {{ $active ? 'text-red-400' : '' }}"></i>
                    <span class="text-sm overflow-hidden whitespace-nowrap nav-label"
                          x-bind:class="(sidebarOpen || mobileMenuOpen) ? 'opacity-100 w-auto' : 'lg:opacity-0 lg:w-0'">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        {{-- Logout --}}
        <div class="p-3 border-t border-zinc-800/60 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-red-600/20 hover:bg-red-600/40 text-red-400 hover:text-red-300 transition-all font-semibold"
                        x-bind:class="(sidebarOpen || mobileMenuOpen) ? '' : 'lg:justify-center lg:px-0'">
                    <i class="ph-bold ph-sign-out text-[18px] shrink-0"></i>
                    <span class="text-sm overflow-hidden whitespace-nowrap nav-label"
                          x-bind:class="(sidebarOpen || mobileMenuOpen) ? 'opacity-100 w-auto' : 'lg:opacity-0 lg:w-0'">
                        Logout
                    </span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden min-w-0">

        {{-- Header --}}
        <header class="h-16 bg-zinc-900 flex items-center justify-between px-4 md:px-5 border-b border-zinc-800 z-10 relative shrink-0">
            <div class="flex items-center gap-3">
                {{-- Desktop hamburger (collapse sidebar) --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden lg:flex w-9 h-9 rounded-xl border border-zinc-700/60 bg-zinc-800/60 items-center justify-center text-zinc-400 hover:text-white hover:border-zinc-600 transition-all focus:outline-none">
                    <i class="ph-bold" :class="sidebarOpen ? 'ph-sidebar-simple' : 'ph-list'" style="font-size:18px;"></i>
                </button>
                {{-- Mobile hamburger (open drawer) --}}
                <button @click="mobileMenuOpen = true"
                        class="flex lg:hidden w-9 h-9 rounded-xl border border-zinc-700/60 bg-zinc-800/60 items-center justify-center text-zinc-400 hover:text-white hover:border-zinc-600 transition-all focus:outline-none">
                    <i class="ph-bold ph-list" style="font-size:18px;"></i>
                </button>
                <span class="text-sm font-semibold text-zinc-400 hidden sm:block truncate max-w-[160px] md:max-w-none">
                    {{ \Illuminate\Support\Str::limit(auth()->user()->gym->name ?? 'Gym Panel', 20) }}
                </span>
            </div>
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 rounded-full bg-red-900/50 text-red-400 flex items-center justify-center font-bold text-sm border border-red-900/60 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-sm font-semibold text-zinc-300 hidden md:block truncate max-w-[120px]">{{ auth()->user()->name }}</span>
            </div>
        </header>

        {{-- Main --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-zinc-950 p-4 md:p-6 lg:p-8">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: "{{ session('success') }}", showConfirmButton: false, timer: 3000, timerProgressBar: true });
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: "{{ $errors->first() }}", showConfirmButton: false, timer: 4000, timerProgressBar: true });
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

</div>

@stack('scripts')
</body>
</html>
