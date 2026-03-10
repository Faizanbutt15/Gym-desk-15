@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ chartType: 'day' }" x-init="fetchDashChartData('day')">

    {{-- Page Header --}}
    <div class="flex items-center justify-between flex-wrap gap-2">
        <div>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-semibold mb-0.5">Gym Admin</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Overview</h1>
        </div>
        
    </div>

    {{-- ── ROW 1: Revenue Metric Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Net Revenue --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Net Revenue</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#dc2626 0%,#7f1d1d 100%);">
                    <i class="ph-fill ph-chart-line-up text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">Rs {{ number_format($netThisMonth, 0) }}</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-500">All-time: <span class="text-zinc-600 dark:text-zinc-400">Rs {{ number_format($netTotal, 0) }}</span></p>
            <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold">
                <i class="ph-fill ph-arrow-up" style="font-size:13px;"></i>
                <span>{{ $netThisMonth >= 0 ? 'Positive' : 'Negative' }} this month</span>
            </div>
        </div>

        {{-- Gross Income --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Gross Income</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#059669 0%,#064e3b 100%);">
                    <i class="ph-fill ph-wallet text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">+Rs {{ number_format($revenueThisMonth, 0) }}</p>
            <p class="text-xs text-zinc-500">All-time: <span class="text-zinc-600 dark:text-zinc-400">Rs {{ number_format($totalRevenue, 0) }}</span></p>
            <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold">
                <i class="ph-fill ph-users" style="font-size:13px;"></i>
                <span>Member fee collections</span>
            </div>
        </div>

        {{-- Spending --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Spending</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#ea580c 0%,#7c2d12 100%);">
                    <i class="ph-fill ph-receipt text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">-Rs {{ number_format($spendingThisMonth, 0) }}</p>
            <p class="text-xs text-zinc-500">All-time: <span class="text-zinc-600 dark:text-zinc-400">Rs {{ number_format($totalSpending, 0) }}</span></p>
            <div class="flex items-center gap-1.5 text-xs text-orange-600 dark:text-emerald-400 font-semibold">
                <i class="ph-fill ph-briefcase" style="font-size:13px;"></i>
                <span>Salaries &amp; Expenses this month</span>
            </div>
        </div>

        {{-- Paid Members --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-5 flex flex-col gap-3 relative overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Paid Members</p>
                <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg"
                      style="background: linear-gradient(135deg,#7c3aed 0%,#3b0764 100%);">
                    <i class="ph-fill ph-seal-check text-white" style="font-size:20px;"></i>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none">{{ $paidMembersThisMonth }}</p>
            <p class="text-xs text-zinc-500">of <span class="text-zinc-600 dark:text-zinc-400">{{ $totalMembers }}</span> total members</p>
            <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold">
                <i class="ph-fill ph-check-circle" style="font-size:13px;"></i>
                <span>Payments collected this month</span>
            </div>
        </div>

    </div>

    {{-- ── ROW 2: Chart + Member Stats Side Panel ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Total Members --}}
        {{-- Revenue Chart --}}
        <div class="lg:col-span-2 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 flex flex-col gap-4">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Revenue Trend</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Income from member fee collections</p>
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

        {{-- Member Stats Side Panel --}}
        <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex flex-col overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <h2 class="text-sm font-bold text-zinc-900 dark:text-white tracking-tight">Member Stats</h2>
                <p class="text-[11px] text-zinc-500 mt-0.5">Quick overview</p>
            </div>
            <div class="flex-1 flex flex-col gap-2.5 p-4">

                {{-- Total Members --}}
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200 cursor-default">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">Total Members</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $totalMembers }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#059669 0%,#064e3b 100%);">
                        <i class="ph-fill ph-users-three text-white" style="font-size:18px;"></i>
                    </span>
                </div>

                {{-- Inactive --}}
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200 cursor-default">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">Inactive</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $inactiveMembers }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#dc2626 0%,#7f1d1d 100%);">
                        <i class="ph-fill ph-user-minus text-white" style="font-size:18px;"></i>
                    </span>
                </div>

                {{-- Expiring Soon --}}
                <a href="{{ route('expiring-soon') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">Expiring Soon</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $expiringSoon }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#d97706 0%,#78350f 100%);">
                        <i class="ph-fill ph-clock-countdown text-white" style="font-size:18px;"></i>
                    </span>
                </a>

                {{-- Expired --}}
                <a href="{{ route('expired') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">Expired</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $expired }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#e11d48 0%,#881337 100%);">
                        <i class="ph-fill ph-warning-circle text-white" style="font-size:18px;"></i>
                    </span>
                </a>

                {{-- New / Month --}}
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/50 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200 cursor-default">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400">New / Month</p>
                        <p class="text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight leading-none mt-0.5">{{ $newMembersThisMonth }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-md"
                          style="background: linear-gradient(135deg,#0d9488 0%,#134e4a 100%);">
                        <i class="ph-fill ph-user-plus text-white" style="font-size:18px;"></i>
                    </span>
                </div>

            </div>{{-- end flex-1 gap-3 p-4 --}}
        </div>{{-- end Member Stats Side Panel --}}

    </div>{{-- end grid --}}

    {{-- ── ROW 3: Recent Payments ── --}}
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm mt-4">
        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Recent Payments</h2>
                <p class="text-[11px] text-zinc-500 mt-0.5">Latest fee collections from members</p>
            </div>
            <a href="{{ route('members.index') }}" class="text-xs font-semibold text-red-600 hover:text-red-700">View Members &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Member</th>
                        <th class="px-6 py-4 font-semibold">Amount</th>
                        <th class="px-6 py-4 font-semibold hidden sm:table-cell">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($recentPayments as $payment)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium inline-block text-zinc-900 dark:text-zinc-100">{{ $payment->member_name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-bold text-xs">
                                    +Rs {{ number_format($payment->amount, 2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400 text-xs hidden sm:table-cell">
                                @if($payment->paid_date)
                                    {{ $payment->paid_date->format('M d, Y') }}
                                @else
                                    {{ $payment->created_at->format('M d, Y') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-3">
                                        <i class="ph-fill ph-receipt text-zinc-400 dark:text-zinc-500 text-2xl"></i>
                                    </span>
                                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">No recent payments</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    let dashChart = null;

    function fetchDashChartData(type) {
        fetch(`{{ route('revenue.chart') }}`, {
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
                theme: 'dark',
                y: { formatter: v => 'Rs ' + Number(v).toLocaleString() }
            },
            grid: {
                borderColor: '#27272a',
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
