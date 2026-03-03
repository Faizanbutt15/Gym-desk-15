@extends('layouts.superadmin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Gyms</h3>
            <span class="text-3xl font-bold text-primary mt-2">{{ $totalGyms }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Active Gyms</h3>
             <span class="text-3xl font-bold text-green-600 mt-2">{{ $activeGyms }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Inactive Gyms</h3>
            <span class="text-3xl font-bold text-red-600 mt-2">{{ $inactiveGyms }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Platform Revenue</h3>
             <span class="text-3xl font-bold text-blue-600 mt-2">${{ number_format($totalRevenue, 2) }}</span>
        </div>
    </div>

    <!-- Recently Added Gyms -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Recently Added Gyms</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-medium">Name</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentGyms as $gym)
                        <tr class="hover:bg-gray-50 transition">
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
                            <td class="px-6 py-4">
                                @if($gym->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $gym->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                No gyms registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
