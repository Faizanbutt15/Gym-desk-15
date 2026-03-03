@extends('layouts.superadmin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-900 to-primary rounded-xl shadow-lg p-6 text-white border border-blue-800 relative overflow-hidden flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-xl">
            <div class="absolute -right-4 -top-4 opacity-10">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path></svg>
            </div>
            <h3 class="text-blue-100 text-sm font-medium uppercase tracking-wider">Total Gyms</h3>
            <span class="text-3xl font-bold mt-2">{{ $totalGyms }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Active Gyms</h3>
            </div>
             <span class="text-3xl font-bold text-green-600">{{ $activeGyms }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Inactive Gyms</h3>
            </div>
            <span class="text-3xl font-bold text-red-600">{{ $inactiveGyms }}</span>
        </div>
        <div class="bg-gray-50 rounded-xl shadow-inner p-6 border border-gray-200 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute -right-2 -bottom-2 opacity-5 text-gray-900">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4h3a3 3 0 116 0h3V6a2 2 0 00-2-2H4zm16 6H4v4a2 2 0 002 2h12a2 2 0 002-2v-4z"></path></svg>
            </div>
            <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider relative z-10">Total Revenue</h3>
             <span class="text-3xl font-extrabold text-gray-900 mt-2 relative z-10">${{ number_format($totalRevenue, 2) }}</span>
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
