@extends('layouts.superadmin')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, paymentModalOpen: false, editGym: {}, paymentGym: {} }">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-semibold mb-0.5">Super Admin</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Manage Gyms</h1>
            <p class="text-xs text-zinc-500 mt-0.5">{{ $gyms->total() }} {{ Str::plural('Gym', $gyms->total()) }} found</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
            <form action="{{ route('superadmin.gyms.index') }}" method="GET" id="gym-filter-form" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                {{-- Search --}}
                <div class="relative w-full sm:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search gyms..."
                           class="pl-9 pr-4 py-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-48 placeholder-zinc-400 dark:placeholder-zinc-500 shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph-bold ph-magnifying-glass text-zinc-400 text-sm"></i>
                    </div>
                </div>

                {{-- Filter Dropdown --}}
                @php
                    $selFilter = request('filter', 'all');
                    $filterOptions = [
                        'all'           => ['label' => 'All Gyms',      'icon' => 'ph-buildings'],
                        'active'        => ['label' => 'Active',        'icon' => 'ph-check-circle'],
                        'inactive'      => ['label' => 'Inactive',      'icon' => 'ph-prohibit'],
                        'expiring_soon' => ['label' => 'Expiring Soon', 'icon' => 'ph-clock'],
                        'expired'       => ['label' => 'Expired',       'icon' => 'ph-warning-circle'],
                    ];
                    $selLabel = $filterOptions[$selFilter]['label'] ?? 'All Gyms';
                @endphp
                <div class="relative" x-data="{ open: false, selected: '{{ $selFilter }}' }" @click.outside="open = false">
                    <button type="button" @click="open = !open"
                            class="flex items-center gap-2 pl-3.5 pr-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-200 text-sm font-medium shadow-sm hover:border-zinc-300 dark:hover:border-zinc-600 transition-all w-full sm:w-auto min-w-[150px]">
                        <i class="ph-bold ph-funnel text-red-500" style="font-size:14px;"></i>
                        <span class="flex-1 text-left">{{ $selLabel }}</span>
                        <i class="ph-bold ph-caret-down text-zinc-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" style="font-size:12px;"></i>
                    </button>
                    <input type="hidden" name="filter" :value="selected">
                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-1.5 w-48 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
                        <div class="py-1">
                            @foreach($filterOptions as $val => $opt)
                                <button type="button"
                                        @click="selected = '{{ $val }}'; open = false; $nextTick(() => document.getElementById('gym-filter-form').submit())"
                                        class="w-full flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition"
                                        :class="selected === '{{ $val }}' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-semibold' : 'text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800'">
                                    <i class="ph-fill {{ $opt['icon'] }}" style="font-size:14px;"></i>
                                    {{ $opt['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>

            <button @click="addModalOpen = true" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm whitespace-nowrap flex items-center justify-center gap-1.5 focus:ring-4 focus:ring-red-500/20">
                <i class="ph-bold ph-plus"></i> Add New Gym
            </button>
        </div>
    </div>

    <!-- Gyms Table -->
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Registered Gyms</h2>
                <p class="text-[11px] text-zinc-500 mt-0.5">List of all gyms and their primary administrators</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Gym Details</th>
                        <th class="px-6 py-4 font-semibold">Primary Admin</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Subscription</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($gyms as $gym)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white flex items-center gap-3">
                                @if($gym->logo)
                                    <img src="{{ asset('storage/' . $gym->logo) }}" class="w-10 h-10 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold border border-blue-200 dark:border-blue-800">
                                        {{ substr($gym->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-zinc-900 dark:text-white">{{ $gym->name }}</div>
                                    <div class="text-zinc-500 dark:text-zinc-400 text-xs font-normal">{{ $gym->address ?? 'No address' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php $admin = $gym->admins->first(); @endphp
                                @if($admin)
                                    <div class="text-zinc-900 dark:text-white font-medium">{{ $admin->name }}</div>
                                    <div class="text-zinc-500 dark:text-zinc-400 text-xs">{{ $admin->email }}</div>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">Missing Admin</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('superadmin.gyms.status', $gym) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $gym->status === 'active' ? 'inactive' : 'active' }}">
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $gym->status === 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 hover:bg-emerald-100 dark:hover:bg-emerald-500/20' : 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 hover:bg-red-100 dark:hover:bg-red-500/20' }} transition cursor-pointer shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $gym->status === 'active' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                        {{ ucfirst($gym->status) }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                @if($gym->subscription_end)
                                    @php
                                        $daysLeft = now()->diffInDays($gym->subscription_end, false);
                                    @endphp
                                    <div class="flex items-center gap-2 text-zinc-700 dark:text-zinc-300">
                                        <span>{{ $gym->subscription_start ? $gym->subscription_start->format('M d, Y') : '-' }} - {{ $gym->subscription_end->format('M d, Y') }}</span>
                                        @if($daysLeft < 0)
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">Expired</span>
                                        @elseif($daysLeft <= 7)
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">Expiring Soon</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-zinc-400 dark:text-zinc-500">Not set</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button @click="paymentGym = {{ json_encode($gym) }}; paymentModalOpen = true" 
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-500/30 transition"
                                            title="Record Payment">
                                        <i class="ph-bold ph-money" style="font-size:13px;"></i>
                                    </button>
                                    <button @click="editGym = {{ json_encode($gym) }}; editModalOpen = true"
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition"
                                            title="Edit">
                                        <i class="ph-bold ph-pencil" style="font-size:13px;"></i>
                                    </button>
                                    <form method="POST" action="{{ route('superadmin.gyms.destroy', $gym) }}" class="inline" id="delete-form-{{ $gym->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $gym->id }}')"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-100 dark:bg-red-500/15 text-red-500 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-500/30 transition"
                                                title="Delete">
                                            <i class="ph-bold ph-trash" style="font-size:13px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-col items-center">
                                    <span class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-3">
                                        <i class="ph-fill ph-buildings text-zinc-400 dark:text-zinc-500 text-2xl"></i>
                                    </span>
                                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">No Gyms Found</span>
                                    <p class="text-xs mt-1">Get started by creating a new gym.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($gyms->hasPages())
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $gyms->links() }}
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" x-transition.opacity class="fixed inset-0 bg-zinc-900/70" @click="addModalOpen = false"></div>
            <div x-show="addModalOpen" x-transition.scale class="relative inline-block w-full max-w-2xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Add New Gym & Admin</h3>
                    <button @click="addModalOpen = false" class="text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 focus:outline-none">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <form action="{{ route('superadmin.gyms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    {{-- Gym Details Section --}}
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <i class="ph-fill ph-buildings text-red-500"></i> Gym Details
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Gym Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 placeholder-zinc-400 outline-none">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Address</label>
                                    <input type="text" name="address" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Logo</label>
                                    <input type="file" name="logo" accept="image/*" class="w-full bg-zinc-50 dark:bg-zinc-950 text-sm text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 rounded-xl file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 dark:file:bg-zinc-800 hover:file:bg-zinc-200 dark:hover:file:bg-zinc-700 transition-all cursor-pointer">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status <span class="text-red-500">*</span></label>
                                    <select name="status" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Subscription Start</label>
                                    <input type="date" name="subscription_start" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Subscription End</label>
                                    <input type="date" name="subscription_end" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                </div>
                            </div>
                            <div class="pt-2 border-t border-zinc-100 dark:border-zinc-800">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Monthly Subscription Payment <span class="text-zinc-400 dark:text-zinc-500 text-xs">(optional)</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-zinc-500 dark:text-zinc-400 sm:text-sm font-medium">Rs</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" name="payment_amount" placeholder="0.00" class="w-full pl-9 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                    </div>
                                    <p class="mt-1 text-xs text-zinc-500">Record an initial subscription payment collected at signup.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Details Section --}}
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <i class="ph-fill ph-user-gear text-red-500"></i> Primary Admin Details
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Admin Name <span class="text-red-500">*</span></label>
                                <input type="text" name="admin_name" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Admin Email <span class="text-red-500">*</span></label>
                                <input type="email" name="admin_email" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Admin Password <span class="text-red-500">*</span></label>
                                <input type="password" name="admin_password" required minlength="8" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800 mt-6">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none shadow-sm transition-all">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/20 shadow-sm transition-all" onclick="this.innerHTML='Saving...'; this.form.submit();">Create Gym & Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-zinc-900/70" @click="editModalOpen = false"></div>
            <div x-show="editModalOpen" x-transition.scale class="relative inline-block w-full max-w-2xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Edit Gym & Admin</h3>
                    <button @click="editModalOpen = false" class="text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 focus:outline-none">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <form :action="'{{ url('superadmin/gyms') }}/' + editGym.id" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    {{-- Gym Details Section --}}
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <i class="ph-fill ph-buildings text-red-500"></i> Gym Details
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Gym Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" :value="editGym.name" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Address</label>
                                    <input type="text" name="address" :value="editGym.address" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Update Logo <span class="text-zinc-400 dark:text-zinc-500 text-xs">(leave empty to keep current)</span></label>
                                    <input type="file" name="logo" accept="image/*" class="w-full bg-zinc-50 dark:bg-zinc-950 text-sm text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 rounded-xl file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 dark:file:bg-zinc-800 hover:file:bg-zinc-200 dark:hover:file:bg-zinc-700 transition-all cursor-pointer">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status <span class="text-red-500">*</span></label>
                                    <select name="status" :value="editGym.status" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Subscription Start</label>
                                    <input type="date" name="subscription_start" :value="editGym.subscription_start ? editGym.subscription_start.substring(0,10) : ''" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Subscription End</label>
                                    <input type="date" name="subscription_end" :value="editGym.subscription_end ? editGym.subscription_end.substring(0,10) : ''" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Details Section --}}
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <i class="ph-fill ph-user-gear text-red-500"></i> Primary Admin Details
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Admin Name <span class="text-red-500">*</span></label>
                                <input type="text" name="admin_name" :value="editGym.admins && editGym.admins.length > 0 ? editGym.admins[0].name : ''" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Admin Email <span class="text-red-500">*</span></label>
                                <input type="email" name="admin_email" :value="editGym.admins && editGym.admins.length > 0 ? editGym.admins[0].email : ''" required class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">New Password <span class="text-zinc-400 dark:text-zinc-500 text-xs">(Leave blank to keep current)</span></label>
                                <input type="password" name="admin_password" minlength="8" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800 mt-6">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none shadow-sm transition-all">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/20 shadow-sm transition-all" onclick="this.innerHTML='Saving...'; this.form.submit();">Update Gym</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Record Payment Modal -->
    <div x-show="paymentModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="paymentModalOpen" x-transition.opacity class="fixed inset-0 bg-zinc-900/70" @click="paymentModalOpen = false"></div>
            <div x-show="paymentModalOpen" x-transition.scale class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Record Gym Payment</h3>
                        <p class="text-xs text-zinc-500 mt-0.5" x-text="'Collect subscription payment from ' + paymentGym.name"></p>
                    </div>
                    <button @click="paymentModalOpen = false" class="text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 focus:outline-none">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                
                <form :action="'{{ url('superadmin/gyms') }}/' + paymentGym.id + '/payments'" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Payment Amount <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-zinc-500 dark:text-zinc-400 sm:text-sm font-medium">Rs</span>
                            </div>
                            <input type="number" step="0.01" min="0.01" name="amount" required placeholder="0.00" class="w-full pl-9 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 rounded-xl px-4 py-2.5 transition-all duration-200 outline-none text-lg font-bold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Paid <span class="text-red-500">*</span></label>
                        <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Notes <span class="text-zinc-400 dark:text-zinc-500 text-xs">(optional)</span></label>
                        <textarea name="notes" rows="2" placeholder="e.g. Subscription for March 2026" class="w-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none resize-none"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800 mt-6">
                        <button type="button" @click="paymentModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none shadow-sm transition-all">Cancel</button>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/20 shadow-sm transition-all flex items-center gap-2" onclick="this.innerHTML='<i class=\'ph-bold ph-spinner animate-spin\'></i> Saving...'; this.form.submit();">
                            <i class="ph-bold ph-check-circle"></i> Record Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone. All data related to this gym (including its admin) will be deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            ...window.gymSwalConfig
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
@endsection
