@extends('layouts.superadmin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Revenue Overview</h1>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Total Revenue by Gym</h2>
        <div id="revenueChart" class="w-full h-80"></div>
    </div>

    <!-- Revenue Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Gym Revenue Breakdown</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-medium">Rank</th>
                        <th class="px-6 py-3 font-medium">Gym Name</th>
                        <th class="px-6 py-3 font-medium text-right">Total Revenue Generated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($gymRevenues as $index => $gym)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-400">#{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-3">
                                @if($gym->logo)
                                    <img src="{{ asset('storage/' . $gym->logo) }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold">
                                        {{ substr($gym->name, 0, 1) }}
                                    </div>
                                @endif
                                {{ $gym->name }}
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-green-600">
                                Rs {{ number_format($gym->payments_sum_amount ?? 0, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                No revenue data available yet.
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
                fontFamily: 'Inter, sans-serif'
            },
            series: seriesData,
            colors: ['#1E3A8A'],
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
                    style: { colors: '#6B7280' }
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

        const chart = new ApexCharts(document.querySelector("#revenueChart"), options);
        chart.render();
    });
</script>
@endpush
@endsection
