@extends('layouts.gym')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col items-center text-center">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Members</h3>
            <span class="text-3xl font-bold text-primary mt-2">{{ $totalMembers }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col items-center text-center">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Active</h3>
             <span class="text-3xl font-bold text-green-600 mt-2">{{ $activeMembers }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col items-center text-center">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Inactive</h3>
            <span class="text-3xl font-bold text-gray-600 mt-2">{{ $inactiveMembers }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-orange-200 bg-orange-50 flex flex-col items-center text-center">
            <h3 class="text-orange-600 text-sm font-bold uppercase tracking-wider">Expiring Soon</h3>
             <span class="text-3xl font-extrabold text-orange-600 mt-2">{{ $expiringSoon }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-red-200 bg-red-50 flex flex-col items-center text-center">
            <h3 class="text-red-700 text-sm font-bold uppercase tracking-wider">Expired</h3>
             <span class="text-3xl font-extrabold text-red-700 mt-2">{{ $expired }}</span>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <a href="{{ route('members.index') }}" class="flex items-center p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition gap-4 group">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-900 group-hover:text-primary transition">Manage Members</h4>
                <p class="text-sm text-gray-500">View, add, or edit your gym members.</p>
            </div>
        </a>
        <a href="{{ route('expiring-soon') }}" class="flex items-center p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition gap-4 group">
            <div class="p-3 bg-orange-100 text-orange-600 rounded-lg group-hover:bg-orange-600 group-hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-900 group-hover:text-primary transition">Expiring Soon</h4>
                <p class="text-sm text-gray-500">Follow up with members expiring within 3 days.</p>
            </div>
        </a>
        <a href="{{ route('revenue.index') }}" class="flex items-center p-6 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition gap-4 group">
            <div class="p-3 bg-green-100 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-900 group-hover:text-primary transition">Revenue Reports</h4>
                <p class="text-sm text-gray-500">Analyze your gym's income and growth.</p>
            </div>
        </a>
    </div>
</div>
@endsection
