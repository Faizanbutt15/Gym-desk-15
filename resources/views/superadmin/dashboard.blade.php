@extends('layouts.superadmin')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ chartType: 'day' }" x-init="fetchDashChartData('day')">

    {{-- Page Header --}}
    <div class="flex items-center justify-between flex-wrap gap-2">
        <div>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-semibold mb-0.5">Super Admin</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Overview</h1>
        </div>
    </div>

    {{-- ── ROW 1: KPI Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Total Revenue --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Total Revenue</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#d97706 0%,#78350f 100%);">
                    <i class="ph-fill ph-coins text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">Rs {{ number_format($totalRevenue, 0) }}</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-500">All-time platform revenue</p>
            <div class="flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400 font-semibold mt-auto pt-2">
                <i class="ph-fill ph-chart-line-up" style="font-size:13px;"></i>
                <span>Collected from all gyms</span>
            </div>
        </div>

        {{-- Revenue (Month) --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Revenue (Month)</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#059669 0%,#064e3b 100%);">
                    <i class="ph-fill ph-wallet text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">+Rs {{ number_format($revenueThisMonth, 0) }}</p>
             <p class="text-xs text-zinc-500 dark:text-zinc-500">Year: <span class="text-zinc-600 dark:text-zinc-400">Rs {{ number_format($revenueThisYear, 0) }}</span></p>
            <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-auto pt-2">
                <i class="ph-fill ph-trend-up" style="font-size:13px;"></i>
                <span>Collected this month</span>
            </div>
        </div>

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
            <p class="text-xs text-zinc-500 dark:text-zinc-500">All registered gyms</p>
            <div class="flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400 font-semibold mt-auto pt-2">
                <i class="ph-fill ph-check-circle" style="font-size:13px;"></i>
                <span>On the platform</span>
            </div>
        </div>

        {{-- Active Gyms --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Active Gyms</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#7c3aed 0%,#3b0764 100%);">
                    <i class="ph-fill ph-seal-check text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">{{ $activeGyms }}</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-500">Currently active on platform</p>
            <div class="flex items-center gap-1.5 text-xs text-purple-600 dark:text-purple-400 font-semibold mt-auto pt-2">
                 <i class="ph-fill ph-users" style="font-size:13px;"></i>
                <span>Paying customers</span>
            </div>
        </div>

    </div>

    {{-- ── ROW 2: Chart + Gym Stats Side Panel ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Revenue Chart --}}
        <div class="lg:col-span-2 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 flex flex-col gap-4">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Revenue Trend</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Income from gym subscription fees</p>
                </div>
                <div class="flex items-center gap-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg p-1">
                    <button @click="chartType = 'day'; fetchDashChartData('day')"
                        :class="{ 'bg-red-600 text-white shadow': chartType === 'day', 'text-zinc-400': chartType !== 'day' }"
                        class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all">30 Days</button>
                    <button @click="chartType = 'month'; fetchDashChartData('month')"
                        :class="{ 'bg-red-600 text-white shadow': chartType === 'month', 'text-zinc-400': chartType !== 'month' }"
                        class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all">12 Months</button>
                    <button @click="chartType = 'year'; fetchDashChartData('year')"
                        :class="{ 'bg-red-600 text-white shadow': chartType === 'year', 'text-zinc-400': chartType !== 'year' }"
                        class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all">All Years</button>
                </div>
            </div>
            <div id="dashRevenueChart" class="w-full" style="min-height:260px;"></div>
        </div>

        {{-- Gym Stats Side Panel --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex flex-col overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <h2 class="text-sm font-bold text-zinc-900 dark:text-white tracking-tight">Platform Stats</h2>
                <p class="text-[11px] text-zinc-500 mt-0.5">Quick overview</p>
            </div>
            <div class="flex-1 flex flex-col gap-2.5 p-4">

                {{-- Expiring Soon Gyms --}}
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200 cursor-default">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">Expiring Soon</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $expiringSoonGyms }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#d97706 0%,#78350f 100%);">
                        <i class="ph-fill ph-clock-countdown text-white" style="font-size:18px;"></i>
                    </span>
                </div>

                {{-- Inactive Gyms --}}
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200 cursor-default">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">Inactive Gyms</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $inactiveGyms }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#dc2626 0%,#7f1d1d 100%);">
                        <i class="ph-fill ph-warning-circle text-white" style="font-size:18px;"></i>
                    </span>
                </div>

                 {{-- Expired Gyms --}}
                 <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200 cursor-default">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">Expired</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $expiredGyms }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#e11d48 0%,#881337 100%);">
                        <i class="ph-fill ph-warning-circle text-white" style="font-size:18px;"></i>
                    </span>
                </div>

            </div>
        </div>
    </div>

    {{-- ── ROW 3: Data Feeds ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mt-4">

        {{-- Recently Added Gyms --}}
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
            <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between bg-zinc-50 dark:bg-zinc-800/50">
                <div>
                    <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Recently Added Gyms</h2>
                    <p class="text-[11px] text-zinc-500 mt-0.5">Latest gyms to join</p>
                </div>
                <a href="{{ route('superadmin.gyms.index') }}" class="text-xs font-semibold text-red-600 hover:text-red-700">View All &rarr;</a>
            </div>
            <div class="overflow-x-auto min-h-[300px]">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/30 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Name</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold hidden sm:table-cell">Joined</th>
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
                                <td colspan="3" class="px-6 py-12 text-center text-zinc-500">
                                    No gyms registered yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

         {{-- Recent Payments feed --}}
         <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
            <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between bg-zinc-50 dark:bg-zinc-800/50">
                <div>
                    <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Recent Payments</h2>
                    <p class="text-[11px] text-zinc-500 mt-0.5">Latest fee collections</p>
                </div>
            </div>
            <div class="overflow-x-auto min-h-[300px]">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/30 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Gym</th>
                            <th class="px-6 py-4 font-semibold">Amount</th>
                            <th class="px-6 py-4 font-semibold hidden sm:table-cell">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @forelse($recentPayments as $payment)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                                <td class="px-6 py-4">
                                    <span class="font-medium inline-block text-zinc-900 dark:text-zinc-100">{{ $payment->gym->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-bold text-xs truncate max-w-[120px]">
                                        +Rs {{ number_format($payment->amount, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400 text-xs hidden sm:table-cell">
                                     {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-zinc-500">
                                    No recent payments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    let dashChart = null;

    function fetchDashChartData(type) {
        if (!type) type = 'day';
        
        // Using the new API route created for the dashboard
        fetch(`{{ route('superadmin.dashboard.chart') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type })
        })
        .then(r => r.json())
        .then(data => renderDashChart(data.categories, data.data));
    }

    function renderDashChart(categories, data) {
        const options = {
            chart: {
                type: 'area',
                height: 260,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                background: 'transparent',
            },
            series: [{ name: 'Revenue', data: data }],
            colors: ['#dc2626'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.0,
                    stops: [0, 95, 100]
                }
            },
            stroke: { curve: 'smooth', width: 2.5, colors: ['#dc2626'] },
            dataLabels: { enabled: false },
            xaxis: {
                categories: categories,
                tickAmount: 6,
                labels: {
                    style: { colors: '#52525b', fontSize: '11px' },
                    rotate: 0,
                    hideOverlappingLabels: true,
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: v => 'Rs ' + (v >= 1000 ? (v/1000).toFixed(1)+'k' : v),
                    style: { colors: '#52525b' }
                }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                y: { formatter: v => 'Rs ' + Number(v).toLocaleString() }
            },
            grid: {
                borderColor: document.documentElement.classList.contains('dark') ? '#27272a' : '#F3F4F6',
                strokeDashArray: 4,
            },
            markers: { size: 0, hover: { size: 5 } }
        };

        if (dashChart) {
            dashChart.updateOptions(options, true, false, false);
            dashChart.updateSeries([{ data: data }]);
        } else {
            dashChart = new ApexCharts(document.querySelector('#dashRevenueChart'), options);
            dashChart.render();
        }
    }
</script>
@endpush
@endsection
