@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ chartType: 'day' }" x-init="fetchChartData('day')">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-100">Revenue Dashboard</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Financial overview for your gym</p>
        </div>
        <div class="bg-zinc-800 p-1 rounded-lg inline-flex self-start sm:self-auto">
            <button @click="chartType = 'day'; fetchChartData('day')" :class="{'bg-red-600 text-white shadow-sm': chartType === 'day', 'text-zinc-400': chartType !== 'day'}" class="px-3 py-1.5 rounded-md text-xs font-semibold transition whitespace-nowrap">30 Days</button>
            <button @click="chartType = 'month'; fetchChartData('month')" :class="{'bg-red-600 text-white shadow-sm': chartType === 'month', 'text-zinc-400': chartType !== 'month'}" class="px-3 py-1.5 rounded-md text-xs font-semibold transition whitespace-nowrap">12 Months</button>
            <button @click="chartType = 'year'; fetchChartData('year')" :class="{'bg-red-600 text-white shadow-sm': chartType === 'year', 'text-zinc-400': chartType !== 'year'}" class="px-3 py-1.5 rounded-md text-xs font-semibold transition whitespace-nowrap">All Years</button>
        </div>
    </div>

    <!-- Highlight Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- Net Revenue Card -->
        <div class="bg-gradient-to-br from-blue-900 to-primary rounded-xl shadow-lg p-6 text-white border border-blue-800 relative overflow-hidden flex flex-col justify-center">
            <div class="absolute -right-4 -top-4 opacity-10">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
            </div>
            <h3 class="text-blue-100 text-sm font-medium uppercase tracking-wider">Net Revenue This Month</h3>
            <span class="text-3xl font-bold mt-2 flex items-baseline gap-2">
                Rs {{ number_format($netThisMonth, 2) }}
            </span>
            <div class="text-xs text-blue-200 mt-2">All-time Net: Rs {{ number_format($netTotal, 2) }}</div>
        </div>
        
        <!-- Income Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col justify-center">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Gross Income (Month)</h3>
            <span class="text-3xl font-bold text-green-600 mt-2">+Rs {{ number_format($revenueThisMonth, 2) }}</span>
            <div class="text-xs text-gray-400 mt-1">All-time: Rs {{ number_format($totalRevenue, 2) }}</div>
        </div>
        
        <!-- Spending Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col justify-center">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Staff Spending (Month)</h3>
            <span class="text-3xl font-bold text-red-500 mt-2">-Rs {{ number_format($spendingThisMonth, 2) }}</span>
             <div class="text-xs text-gray-400 mt-1">All-time: -Rs {{ number_format($totalSpending, 2) }}</div>
        </div>
        
        <!-- Paid Members -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-200 bg-green-50 flex flex-col justify-center">
            <h3 class="text-green-700 text-sm font-bold uppercase tracking-wider">Paid Members This Month</h3>
             <span class="text-3xl font-extrabold text-green-700 mt-2">{{ $paidMembersThisMonth }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Revenue Trend</h2>
            <div id="revenueChart" class="w-full h-80"></div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Recent Payments</h2>
            </div>
            <div class="flex-1 overflow-y-auto p-0">
                <ul class="divide-y divide-gray-100">
                    @forelse($recentPayments as $payment)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $payment->member_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->paid_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="text-sm font-bold text-gray-900">
                                +Rs {{ number_format($payment->amount, 2) }}
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center text-sm text-gray-500">
                            No recent payments found.
                        </li>
                    @endforelse
                </ul>
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50 text-center">
                <a href="{{ route('members.index') }}" class="text-sm font-medium text-primary hover:text-blue-800 transition">View all members &rarr;</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let chartInstance = null;

    function fetchChartData(type) {
        if (!type) type = 'day';
        
        fetch(`{{ route('revenue.chart') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type })
        })
        .then(response => response.json())
        .then(data => {
            renderChart(data.categories, data.data);
        });
    }

    function renderChart(categories, data) {
        const options = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            series: [{
                name: 'Revenue',
                data: data
            }],
            colors: ['#1E3A8A'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '50%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: categories,
                labels: {
                    style: { colors: '#6B7280', fontSize: '11px' }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return "Rs " + val;
                    },
                    style: { colors: '#6B7280' }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rs " + val
                    }
                }
            },
            grid: {
                borderColor: '#F3F4F6',
                strokeDashArray: 4,
            }
        };

        if (chartInstance) {
            chartInstance.updateOptions(options, true, false, false);
            chartInstance.updateSeries([{ data: data }]);
        } else {
            chartInstance = new ApexCharts(document.querySelector("#revenueChart"), options);
            chartInstance.render();
        }
    }
</script>
@endpush
@endsection
