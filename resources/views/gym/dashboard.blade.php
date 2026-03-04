@extends('layouts.gym')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-gradient-to-br from-blue-900 to-primary rounded-xl shadow-lg p-6 border border-blue-800 flex flex-col items-center text-center transform transition duration-300 hover:scale-105 hover:shadow-xl relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 opacity-10 text-white">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
            </div>
            <h3 class="text-blue-100 text-xs font-semibold uppercase tracking-wider relative z-10">Total Members</h3>
            <span class="text-4xl font-extrabold text-white mt-1 relative z-10">{{ $totalMembers }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100 flex flex-col items-center text-center">
            <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Active</h3>
             <span class="text-3xl font-bold text-gray-900 mt-1">{{ $activeMembers }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100 flex flex-col items-center text-center">
            <div class="w-10 h-10 rounded-full bg-gray-50 text-gray-500 flex items-center justify-center mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
            <h3 class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Inactive</h3>
            <span class="text-3xl font-bold text-gray-900 mt-1">{{ $inactiveMembers }}</span>
        </div>
        <div class="bg-orange-50 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-orange-100 flex flex-col items-center text-center">
            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-orange-700 text-xs font-bold uppercase tracking-wider">Expiring Soon</h3>
             <span class="text-3xl font-extrabold text-orange-600 mt-1">{{ $expiringSoon }}</span>
        </div>
        <div class="bg-red-50 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-red-100 flex flex-col items-center text-center">
            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-red-700 text-xs font-bold uppercase tracking-wider">Expired</h3>
             <span class="text-3xl font-extrabold text-red-600 mt-1">{{ $expired }}</span>
        </div>
        <div class="bg-indigo-50 rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-indigo-100 flex flex-col items-center text-center">
            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <h3 class="text-indigo-700 text-xs font-bold uppercase tracking-wider">New This Month</h3>
             <span class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $newMembersThisMonth }}</span>
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
