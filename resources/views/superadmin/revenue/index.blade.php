@extends('layouts.superadmin')

@section('content')
<div class="space-y-4 md:space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between flex-wrap gap-2">
        <div>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-semibold mb-0.5">Super Admin</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Revenue Overview</h1>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 flex flex-col gap-4 shadow-sm">
        <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Total Revenue by Gym</h2>
        <div id="revenueChart" class="w-full h-80"></div>
    </div>

    <!-- Revenue Table -->
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm mt-4">
        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Gym Revenue Breakdown</h2>
                <p class="text-[11px] text-zinc-500 mt-0.5">Top performing gyms by generated revenue</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Rank</th>
                        <th class="px-6 py-4 font-semibold">Gym Name</th>
                        <th class="px-6 py-4 font-semibold text-right">Total Revenue Generated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($gymRevenues as $index => $gym)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4 font-bold text-zinc-400 dark:text-zinc-500">#{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white flex items-center gap-3">
                                @if($gym->logo)
                                    <img src="{{ asset('storage/' . $gym->logo) }}" class="w-8 h-8 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-xs border border-blue-200 dark:border-blue-800">
                                        {{ substr($gym->name, 0, 1) }}
                                    </div>
                                @endif
                                {{ $gym->name }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-bold text-xs">
                                    +Rs {{ number_format($gym->gym_payments_sum_amount ?? 0, 2) }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-col items-center">
                                    <span class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-3">
                                        <i class="ph-fill ph-chart-bar text-zinc-400 dark:text-zinc-500 text-2xl"></i>
                                    </span>
                                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">No revenue data available yet.</span>
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
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData);
        const categories = @json($chartCategories);
        
        // ApexCharts looks for series array
        const seriesData = [{
            name: 'Total Revenue',
            data: chartData.map(gym => gym.data[0] || 0)
        }];
        
        const gymNames = chartData.map(gym => gym.name);

        const options = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                background: 'transparent'
            },
            series: seriesData,
            colors: ['#dc2626'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '40%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: gymNames,
                labels: {
                    style: { colors: '#71717a' }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return "Rs " + val;
                    },
                    style: { colors: '#71717a' }
                }
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return "Rs " + val
                    }
                }
            },
            grid: {
                borderColor: '#27272a',
                strokeDashArray: 4,
            }
        };

        const chart = new ApexCharts(document.querySelector("#revenueChart"), options);
        chart.render();
    });
</script>
@endpush
@endsection
