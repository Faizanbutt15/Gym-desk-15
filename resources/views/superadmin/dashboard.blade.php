@extends('layouts.superadmin')

@section('content')
<div class="space-y-4 md:space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between flex-wrap gap-2">
        <div>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-semibold mb-0.5">Super Admin</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Overview</h1>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Total Gyms --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Total Gyms</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#3b82f6 0%,#1e3a8a 100%);">
                    <i class="ph-fill ph-buildings text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">{{ $totalGyms }}</p>
            <div class="flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400 font-semibold mt-auto pt-2">
                <i class="ph-fill ph-check-circle" style="font-size:13px;"></i>
                <span>All registered gyms</span>
            </div>
        </div>

        {{-- Active Gyms --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Active Gyms</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#059669 0%,#064e3b 100%);">
                    <i class="ph-fill ph-check-circle text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">{{ $activeGyms }}</p>
            <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-auto pt-2">
                <i class="ph-fill ph-trend-up" style="font-size:13px;"></i>
                <span>Currently active</span>
            </div>
        </div>

        {{-- Inactive Gyms --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Inactive Gyms</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#dc2626 0%,#7f1d1d 100%);">
                    <i class="ph-fill ph-warning-circle text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">{{ $inactiveGyms }}</p>
            <div class="flex items-center gap-1.5 text-xs text-red-600 dark:text-red-400 font-semibold mt-auto pt-2">
                <i class="ph-fill ph-warning" style="font-size:13px;"></i>
                <span>Requires attention</span>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Total Revenue</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#d97706 0%,#78350f 100%);">
                    <i class="ph-fill ph-coins text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">Rs {{ number_format($totalRevenue, 2) }}</p>
            <div class="flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400 font-semibold mt-auto pt-2">
                <i class="ph-fill ph-chart-line-up" style="font-size:13px;"></i>
                <span>Platform revenue</span>
            </div>
        </div>

    </div>

    {{-- Recently Added Gyms --}}
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm mt-4">
        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Recently Added Gyms</h2>
                <p class="text-[11px] text-zinc-500 mt-0.5">Latest gyms to join the platform</p>
            </div>
            <a href="{{ route('superadmin.gyms.index') }}" class="text-xs font-semibold text-red-600 hover:text-red-700">View All Gyms &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Name</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold hidden sm:table-cell">Joined Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($recentGyms as $gym)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium inline-block text-zinc-900 dark:text-zinc-100 flex items-center gap-3">
                                    @if($gym->logo)
                                        <img src="{{ asset('storage/' . $gym->logo) }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-xs ring-1 ring-blue-200 dark:ring-blue-800">
                                            {{ substr($gym->name, 0, 1) }}
                                        </div>
                                    @endif
                                    {{ $gym->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($gym->status === 'active')
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-bold text-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 font-bold text-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Inactive
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400 text-xs hidden sm:table-cell">
                                {{ $gym->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-3">
                                        <i class="ph-fill ph-buildings text-zinc-400 dark:text-zinc-500 text-2xl"></i>
                                    </span>
                                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">No gyms registered yet</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
