<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gymdesk15</title>
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
        .sidebar-transition { transition: width 0.25s cubic-bezier(0.4,0,0.2,1); }
        .nav-label { transition: opacity 0.15s ease, width 0.2s ease; }
    </style>
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-700 dark:text-zinc-300 font-sans antialiased"
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
    <aside
        class="bg-white dark:bg-black text-zinc-800 dark:text-white flex flex-col h-full border-r border-zinc-200 dark:border-zinc-800/60 z-40 flex-shrink-0
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
        <div class="h-16 flex items-center border-b border-zinc-200 dark:border-zinc-800/60 px-4 overflow-hidden whitespace-nowrap shrink-0">
            <span class="ml-1 font-bold text-zinc-800 dark:text-white text-lg tracking-tight overflow-hidden transition-all duration-200"
                  x-bind:class="{ 'opacity-100 max-w-full': sidebarOpen || mobileMenuOpen, 'opacity-0 max-w-0 lg:hidden': !sidebarOpen && !mobileMenuOpen }">
                <span class="text-red-500">Gym</span>desk-15
            </span>
            {{-- Mobile close button --}}
            <button @click="mobileMenuOpen = false" class="ml-auto lg:hidden text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                <i class="ph-bold ph-x" style="font-size:18px;"></i>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden space-y-0.5 px-2">
            @php
                $navItems = [
                    ['route' => 'superadmin.dashboard',    'match' => 'superadmin.dashboard',   'icon' => 'ph-squares-four',    'label' => 'Dashboard', 'iconWeight' => 'ph-fill'],
                    ['route' => 'superadmin.gyms.index',     'match' => 'superadmin.gyms.*',       'icon' => 'ph-buildings',           'label' => 'Gyms'],
                ];
            @endphp
            @foreach($navItems as $item)
                @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 group relative overflow-hidden
                          {{ $active
                              ? 'bg-red-50 dark:bg-red-900/50 text-red-600 dark:text-red-400 font-semibold'
                              : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/70 hover:text-zinc-900 dark:hover:text-white' }}"
                   x-bind:class="(sidebarOpen || mobileMenuOpen) ? '' : 'lg:justify-center lg:px-0'"
                   title="{{ $item['label'] }}">
                    @if($active)
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-[3px] bg-red-500 rounded-r-full"></span>
                    @endif
                    <i class="{{ $item['iconWeight'] ?? 'ph-bold' }} {{ $item['icon'] }} text-[18px] shrink-0 {{ $active ? 'text-red-500 dark:text-red-400' : '' }}"></i>
                    <span class="text-sm overflow-hidden whitespace-nowrap nav-label"
                          x-bind:class="(sidebarOpen || mobileMenuOpen) ? 'opacity-100 w-auto' : 'lg:opacity-0 lg:w-0'">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        {{-- Logout --}}
        <div class="p-3 border-t border-zinc-200 dark:border-zinc-800/60 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-red-50 dark:bg-red-600/20 hover:bg-red-100 dark:hover:bg-red-600/40 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-all font-semibold"
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
        <header class="h-16 bg-white dark:bg-zinc-900 flex items-center justify-between px-4 md:px-5 border-b border-zinc-200 dark:border-zinc-800 z-10 relative shrink-0">
            <div class="flex items-center gap-3">
                {{-- Desktop hamburger (collapse sidebar) --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden lg:flex w-9 h-9 rounded-xl border border-zinc-200 dark:border-zinc-700/60 bg-zinc-50 dark:bg-zinc-800/60 items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-600 transition-all focus:outline-none">
                    <i class="ph-bold" :class="sidebarOpen ? 'ph-sidebar-simple' : 'ph-list'" style="font-size:18px;"></i>
                </button>
                {{-- Mobile hamburger (open drawer) --}}
                <button @click="mobileMenuOpen = true"
                        class="flex lg:hidden w-9 h-9 rounded-xl border border-zinc-200 dark:border-zinc-700/60 bg-zinc-50 dark:bg-zinc-800/60 items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-600 transition-all focus:outline-none">
                    <i class="ph-bold ph-list" style="font-size:18px;"></i>
                </button>
                <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 hidden sm:block truncate max-w-[160px] md:max-w-none">
                    Super Admin Panel
                </span>
            </div>
            <div class="flex items-center gap-2 md:gap-3">

                {{-- Dark / Light Mode Toggle --}}
                <button id="theme-toggle"
                        onclick="toggleTheme()"
                        class="w-9 h-9 rounded-xl border border-zinc-200 dark:border-zinc-700/60 bg-zinc-50 dark:bg-zinc-800/60 flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-600 transition-all focus:outline-none"
                        title="Toggle theme">
                    {{-- Sun icon shown in dark mode (click to go light) --}}
                    <i id="theme-icon-sun" class="ph-bold ph-sun" style="font-size:18px;"></i>
                    {{-- Moon icon shown in light mode (click to go dark) --}}
                    <i id="theme-icon-moon" class="ph-bold ph-moon hidden" style="font-size:18px;"></i>
                </button>

                <div class="w-8 h-8 rounded-full bg-red-50 dark:bg-red-900/50 text-red-500 dark:text-red-400 flex items-center justify-center font-bold text-sm border border-red-200 dark:border-red-900/60 shrink-0">
                    SA
                </div>
                <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 hidden md:block truncate max-w-[120px]">Super Admin</span>
            </div>
        </header>

        {{-- Main --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-zinc-50 dark:bg-zinc-950 p-4 md:p-6 lg:p-8">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: "{{ session('success') }}", showConfirmButton: false, timer: 3000, timerProgressBar: true, customClass: { popup: 'bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl', title: 'text-zinc-900 dark:text-white' } });
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: "{{ $errors->first() }}", showConfirmButton: false, timer: 4000, timerProgressBar: true, customClass: { popup: 'bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl', title: 'text-zinc-900 dark:text-white' } });
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

</div>

<script>
    // Global SweetAlert Config for the Black/Red/White theme supporting Light/Dark modes
    window.gymSwalConfig = {
        customClass: {
            popup: 'bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-xl',
            title: 'text-xl font-bold text-zinc-900 dark:text-white',
            htmlContainer: 'text-zinc-500 dark:text-zinc-400',
            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg px-4 py-2 border-0',
            cancelButton: 'bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-white font-semibold rounded-lg px-4 py-2 border-0 mx-2',
            actions: 'gap-3 mt-4'
        },
        buttonsStyling: false
    };

    window.confirmFormSubmit = function(event, formElement, title, text, confirmText) {
        event.preventDefault();
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmText || 'Yes, confirm!',
            ...window.gymSwalConfig
        }).then((result) => {
            if (result.isConfirmed) {
                formElement.submit();
            }
        });
    }

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

    // Sync icon on page load
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
