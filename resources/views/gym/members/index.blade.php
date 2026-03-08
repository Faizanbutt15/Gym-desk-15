@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, viewModalOpen: false, editMember: {}, viewMember: {} }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-100">Members</h1>
            <p class="text-xs text-zinc-500 mt-0.5">{{ $members->total() }} {{ Str::plural('Member', $members->total()) }} found</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
            <form action="{{ route('members.index') }}" method="GET" id="member-filter-form" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                {{-- Search --}}
                <div class="relative w-full sm:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search members..."
                           class="pl-9 pr-4 py-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-48 placeholder-zinc-400 dark:placeholder-zinc-500 shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph-bold ph-magnifying-glass text-zinc-400 text-sm"></i>
                    </div>
                </div>

                {{-- Filter Dropdown --}}
                @php
                    $selFilter = request('filter', 'all');
                    $filterOptions = [
                        'all'          => ['label' => 'All Members',   'icon' => 'ph-users'],
                        'active'       => ['label' => 'Active',        'icon' => 'ph-check-circle'],
                        'inactive'     => ['label' => 'Inactive',      'icon' => 'ph-prohibit'],
                        'with_trainer' => ['label' => 'With Trainer',  'icon' => 'ph-person-arms-spread'],
                        'no_trainer'   => ['label' => 'No Trainer',    'icon' => 'ph-person-simple'],
                        'with_locker'  => ['label' => 'With Locker',   'icon' => 'ph-lock-key'],
                        'no_locker'    => ['label' => 'No Locker',     'icon' => 'ph-lock-open'],
                    ];
                    $selLabel = $filterOptions[$selFilter]['label'] ?? 'All Members';
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
                                        @click="selected = '{{ $val }}'; open = false; $nextTick(() => document.getElementById('member-filter-form').submit())"
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
            <button @click="addModalOpen = true" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm whitespace-nowrap flex items-center justify-center gap-1.5">
                <i class="ph-bold ph-plus"></i> Add Member
            </button>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Member</th>
                        <th class="px-4 py-3 font-semibold hidden md:table-cell">Contact</th>
                        <th class="px-4 py-3 font-semibold">Fee/Month</th>
                        <th class="px-4 py-3 font-semibold hidden lg:table-cell">Due Date</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($members as $member)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" class="w-9 h-9 rounded-full object-cover border border-zinc-700 shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center font-bold border border-red-200 dark:border-red-900/40 shrink-0 text-sm">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="text-zinc-900 dark:text-zinc-100 font-semibold truncate max-w-[120px] lg:max-w-none">{{ $member->name }}</div>
                                        <div class="text-zinc-400 dark:text-zinc-500 text-xs truncate max-w-[120px] lg:max-w-none">{{ $member->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 hidden md:table-cell whitespace-nowrap">
                                {{ $member->contact ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($member->fee_amount + $member->trainer_fee + $member->locker_fee, 2) }}</span>
                                @if($member->trainer_fee > 0 || $member->locker_fee > 0)
                                    <div class="text-[10px] text-zinc-500 mt-0.5">+ extras</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 hidden lg:table-cell whitespace-nowrap">
                                @if($member->fee_due_date)
                                    @php $daysLeft = now()->startOfDay()->diffInDays($member->fee_due_date, false); @endphp
                                    <div class="font-medium text-sm {{ $daysLeft < 0 ? 'text-red-500 dark:text-red-400' : ($daysLeft <= 3 ? 'text-orange-500 dark:text-orange-400' : 'text-zinc-600 dark:text-zinc-300') }}">
                                        {{ $member->fee_due_date->format('M d, Y') }}
                                        @if($daysLeft < 0)
                                            <span class="ml-1 text-[10px] text-red-500 font-bold">(Expired)</span>
                                        @elseif($daysLeft <= 3)
                                            <span class="ml-1 text-[10px] text-orange-500 font-bold">(Soon)</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-zinc-600">Not set</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($member->status === 'active')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/50">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <form method="POST" action="{{ route('members.markPaid', $member) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-500/30 transition"
                                                onclick="return confirm('Mark as Paid? This will add 30 days to due date and record a payment.')"
                                                title="Mark Paid">
                                            <i class="ph-bold ph-check" style="font-size:13px;"></i>
                                        </button>
                                    </form>
                                    <button @click="viewMember = {{ json_encode($member) }}; viewModalOpen = true"
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-sky-100 dark:bg-sky-500/15 text-sky-600 dark:text-sky-400 hover:bg-sky-200 dark:hover:bg-sky-500/30 transition"
                                            title="View">
                                        <i class="ph-bold ph-eye" style="font-size:13px;"></i>
                                    </button>
                                    <button @click="editMember = {{ json_encode($member) }}; editModalOpen = true"
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition"
                                            title="Edit">
                                        <i class="ph-bold ph-pencil" style="font-size:13px;"></i>
                                    </button>
                                    <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline" id="delete-form-{{ $member->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $member->id }}')"
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
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                                <div class="flex flex-col items-center">
                                    <i class="ph-fill ph-users text-zinc-300 dark:text-zinc-700 mb-3" style="font-size:48px;"></i>
                                    <span class="text-base font-medium text-zinc-500 dark:text-zinc-400">No Members Found</span>
                                    <p class="text-sm text-zinc-400 dark:text-zinc-600 mt-1">Add your first member to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
        <div class="px-4 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $members->links() }}
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" class="fixed inset-0 transition-opacity bg-black/60" @click="addModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Add New Member</h3>
                    <button @click="addModalOpen = false" class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-500 dark:text-zinc-400 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email Address</label>
                            <input type="email" name="email" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Contact Number</label>
                            <input type="text" name="contact" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Monthly Gym Fee ($) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="fee_amount" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Admission Fee ($) <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(One-time)</span></label>
                            <input type="number" step="0.01" name="admission_fee" value="0.00" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Trainer Fee ($) <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Monthly)</span></label>
                            <input type="number" step="0.01" name="trainer_fee" value="0.00" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Locker Fee ($) <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Monthly)</span></label>
                            <input type="number" step="0.01" name="locker_fee" value="0.00" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Next Fee Due Date</label>
                            <input type="date" name="fee_due_date" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Joined Date</label>
                            <input type="date" name="joined_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Photo</label>
                            <div x-data="{ cameraActive: false, capturedImage: null }" class="space-y-3">
                                <div x-show="!capturedImage" class="flex items-center gap-3">
                                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-zinc-500 dark:text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 dark:bg-red-900/30 file:text-red-500 hover:file:bg-red-100 dark:hover:file:bg-red-900/50 border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100">
                                    <span class="text-sm text-zinc-400 dark:text-zinc-500 font-medium">OR</span>
                                    <button type="button" @click="cameraActive = true; initCamera($refs.videoElement)" x-show="!cameraActive" class="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-md border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm text-sm hover:bg-gray-200 whitespace-nowrap font-medium flex-shrink-0">
                                        📷 Open Camera
                                    </button>
                                </div>
                                
                                <input type="hidden" name="photo_base64" :value="capturedImage">

                                <div x-show="cameraActive && !capturedImage" class="relative bg-zinc-900 dark:bg-black rounded-lg overflow-hidden flex flex-col items-center">
                                    <video x-ref="videoElement" autoplay playsinline class="w-full max-h-64 object-cover"></video>
                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3">
                                        <button type="button" @click="cameraActive = false; stopCamera($refs.videoElement)" class="px-4 py-2 bg-red-600 text-white rounded-full shadow-md text-sm font-bold hover:bg-red-700">Cancel</button>
                                        <button type="button" @click="capturedImage = captureImage($refs.videoElement, $refs.canvasElement); stopCamera($refs.videoElement); cameraActive = false;" class="px-4 py-2 bg-green-500 text-white rounded-full shadow-md text-sm font-bold hover:bg-green-600">Take Photo</button>
                                    </div>
                                    <canvas x-ref="canvasElement" class="hidden"></canvas>
                                </div>

                                <div x-show="capturedImage" class="relative inline-block">
                                    <img :src="capturedImage" class="h-32 w-32 object-cover rounded-xl border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm">
                                    <button type="button" @click="capturedImage = null" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:bg-red-600 text-xs font-bold">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-100 dark:border-zinc-800/80">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800/50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Save Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="editModalOpen" class="fixed inset-0 transition-opacity bg-black/60" @click="editModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Edit Member</h3>
                    <button @click="editModalOpen = false" class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-500 dark:text-zinc-400 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('members') }}/' + editMember.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="editMember.name" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email Address</label>
                            <input type="email" name="email" x-model="editMember.email" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Contact Number</label>
                            <input type="text" name="contact" x-model="editMember.contact" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Monthly Gym Fee ($) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="fee_amount" x-model="editMember.fee_amount" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Admission Fee ($) <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(One-time)</span></label>
                            <input type="number" step="0.01" name="admission_fee" x-model="editMember.admission_fee" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Trainer Fee ($) <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Monthly, set to 0 to remove)</span></label>
                            <input type="number" step="0.01" name="trainer_fee" x-model="editMember.trainer_fee" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Locker Fee ($) <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Monthly, set to 0 to remove)</span></label>
                            <input type="number" step="0.01" name="locker_fee" x-model="editMember.locker_fee" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Fee Due Date</label>
                            <input type="date" name="fee_due_date" x-model="editMember.fee_due_date ? editMember.fee_due_date.substring(0,10) : ''" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status <span class="text-red-500">*</span></label>
                            <select name="status" x-model="editMember.status" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Update Photo <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(leave empty to keep current)</span></label>
                            <div x-data="{ cameraActive: false, capturedImage: null }" class="space-y-3">
                                <div x-show="!capturedImage" class="flex items-center gap-3">
                                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-zinc-500 dark:text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 dark:bg-red-900/30 file:text-red-500 hover:file:bg-red-100 dark:hover:file:bg-red-900/50 border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100">
                                    <span class="text-sm text-zinc-400 dark:text-zinc-500 font-medium">OR</span>
                                    <button type="button" @click="cameraActive = true; initCamera($refs.videoElement)" x-show="!cameraActive" class="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-md border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm text-sm hover:bg-gray-200 whitespace-nowrap font-medium flex-shrink-0">
                                        📷 Open Camera
                                    </button>
                                </div>
                                
                                <input type="hidden" name="photo_base64" :value="capturedImage">

                                <div x-show="cameraActive && !capturedImage" class="relative bg-zinc-900 dark:bg-black rounded-lg overflow-hidden flex flex-col items-center">
                                    <video x-ref="videoElement" autoplay playsinline class="w-full max-h-64 object-cover"></video>
                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3">
                                        <button type="button" @click="cameraActive = false; stopCamera($refs.videoElement)" class="px-4 py-2 bg-red-600 text-white rounded-full shadow-md text-sm font-bold hover:bg-red-700">Cancel</button>
                                        <button type="button" @click="capturedImage = captureImage($refs.videoElement, $refs.canvasElement); stopCamera($refs.videoElement); cameraActive = false;" class="px-4 py-2 bg-green-500 text-white rounded-full shadow-md text-sm font-bold hover:bg-green-600">Take Photo</button>
                                    </div>
                                    <canvas x-ref="canvasElement" class="hidden"></canvas>
                                </div>

                                <div x-show="capturedImage" class="relative inline-block">
                                    <img :src="capturedImage" class="h-32 w-32 object-cover rounded-xl border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm">
                                    <button type="button" @click="capturedImage = null" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:bg-red-600 text-xs font-bold">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-100 dark:border-zinc-800/80">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800/50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal (Card Style) -->
    <div x-show="viewModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="viewModalOpen" class="fixed inset-0 transition-opacity bg-black/80" @click="viewModalOpen = false"></div>
            
            <div class="relative inline-block w-full max-w-[360px] overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 shadow-2xl rounded-2xl flex flex-col h-[85vh] sm:h-auto sm:max-h-[90vh]">
                
                <!-- Scrollable Content Area -->
                <div class="flex-1 overflow-y-auto w-full bg-white dark:bg-zinc-900 relative pb-16">
                    
                    <!-- Top Dark Header Section -->
                    <div class="bg-black dark:bg-zinc-950 pt-4 pb-8 px-4 relative flex flex-col items-center">
                        <!-- Top Actions (Back & Check) -->
                        <div class="w-full flex justify-between items-center text-white mb-2 relative left-0 px-1">
                            <button @click="viewModalOpen = false" class="text-white hover:text-gray-300 transition focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </button>
                            <button @click="viewModalOpen = false; editMember = viewMember; editModalOpen = true" class="text-white hover:text-gray-300 transition focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                        
                        <!-- Profile Image Avatar -->
                        <div class="flex justify-center mt-1 relative z-10 w-full">
                            <template x-if="viewMember.photo">
                                <img :src="'/storage/' + viewMember.photo" class="w-32 h-32 rounded-full object-cover border-2 border-white dark:border-zinc-800 shadow-sm bg-white dark:bg-zinc-900">
                            </template>
                            <template x-if="!viewMember.photo">
                                <div class="w-32 h-32 rounded-full bg-red-100 dark:bg-red-900/50 text-red-500 flex items-center justify-center font-bold text-5xl shadow-sm border-2 border-white dark:border-zinc-800" x-text="viewMember.name ? viewMember.name.substring(0, 1) : ''"></div>
                            </template>
                        </div>
                        
                        <div class="text-center mt-3 mb-1">
                            <h3 class="text-xl font-medium text-white tracking-wide" x-text="viewMember.name"></h3>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="flex justify-center border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
                        <form method="POST" :action="'{{ url('gym/members') }}/' + viewMember.id + '/mark-paid'" class="w-1/2 border-r border-zinc-200 dark:border-zinc-700" x-ref="markPaidForm">
                            @csrf
                            <button type="button" @click="$refs.markPaidForm.submit()" class="w-full flex flex-col items-center justify-center gap-1.5 py-3 hover:bg-zinc-50 dark:bg-zinc-800/50 transition text-zinc-700 dark:text-zinc-300">
                                <svg class="w-5 h-5 text-zinc-800 dark:text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span class="text-[11px] font-semibold text-zinc-800 dark:text-zinc-200">Mark Paid</span>
                            </button>
                        </form>
                        <button type="button" @click="viewModalOpen = false; editMember = viewMember; editModalOpen = true" class="w-1/2 flex flex-col items-center justify-center gap-1.5 py-3 hover:bg-zinc-50 dark:bg-zinc-800/50 transition text-zinc-700 dark:text-zinc-300">
                            <svg class="w-5 h-5 text-zinc-800 dark:text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-[11px] font-semibold text-zinc-800 dark:text-zinc-200">Edit Member</span>
                        </button>
                    </div>

                    <!-- Details Section Head -->
                    <div class="bg-zinc-100 dark:bg-zinc-800 px-4 py-2 flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-700">
                        <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        <span class="text-xs uppercase tracking-wider font-bold text-black dark:text-white">Details</span>
                    </div>

                    <!-- Details List -->
                    <div class="px-4 bg-white dark:bg-zinc-900 divide-y divide-gray-100 text-sm">
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium">Status</span>
                            <span class="text-zinc-800 dark:text-zinc-200 w-2/3 font-medium text-[13px]" x-text="viewMember.status === 'active' ? 'Active' : 'Inactive'"></span>
                        </div>
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium">Gym Fee</span>
                            <span class="text-zinc-800 dark:text-zinc-200 w-2/3 font-bold text-[13px]" x-text="'$' + (viewMember.fee_amount ? parseFloat(viewMember.fee_amount).toFixed(2) : '0.00')"></span>
                        </div>
                        <template x-if="viewMember.trainer_fee > 0">
                            <div class="py-3.5 flex items-center justify-between">
                                <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium">Trainer Fee</span>
                                <span class="text-zinc-800 dark:text-zinc-200 w-2/3 font-bold text-[13px] text-red-600 dark:text-red-400" x-text="'$' + parseFloat(viewMember.trainer_fee).toFixed(2) + ' /mo'"></span>
                            </div>
                        </template>
                        <template x-if="viewMember.locker_fee > 0">
                            <div class="py-3.5 flex items-center justify-between">
                                <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium">Locker Fee</span>
                                <span class="text-zinc-800 dark:text-zinc-200 w-2/3 font-bold text-[13px] text-purple-600 dark:text-purple-400" x-text="'$' + parseFloat(viewMember.locker_fee).toFixed(2) + ' /mo'"></span>
                            </div>
                        </template>
                        <div class="py-3.5 flex items-center justify-between bg-zinc-50 dark:bg-zinc-800/50 -mx-4 px-4 border-y border-zinc-100 dark:border-zinc-800/80">
                            <span class="text-zinc-500 dark:text-zinc-400 w-1/3 text-[13px] font-bold">Total Monthly</span>
                            <span class="text-green-600 w-2/3 font-bold text-[14px]" x-text="'$' + (parseFloat(viewMember.fee_amount || 0) + parseFloat(viewMember.trainer_fee || 0) + parseFloat(viewMember.locker_fee || 0)).toFixed(2)"></span>
                        </div>
                        <template x-if="viewMember.admission_fee > 0">
                            <div class="py-3.5 flex items-center justify-between">
                                <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium">Admission</span>
                                <span class="text-zinc-500 dark:text-zinc-400 w-2/3 font-medium text-[13px]" x-text="'$' + parseFloat(viewMember.admission_fee).toFixed(2) + ' (Paid once)'"></span>
                            </div>
                        </template>
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium">Joined Date</span>
                            <div class="w-2/3 flex items-center justify-between">
                                <span class="text-zinc-800 dark:text-zinc-200 font-medium text-[13px]" x-text="viewMember.joined_date ? new Date(viewMember.joined_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : ''"></span>
                            </div>
                        </div>
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium">Due Date</span>
                            <div class="w-2/3 flex items-center justify-between">
                                <span class="text-zinc-800 dark:text-zinc-200 font-medium text-[13px]" x-text="viewMember.fee_due_date ? new Date(viewMember.fee_due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : ''"></span>
                                <svg class="w-4 h-4 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info Section Head -->
                    <div class="bg-zinc-100 dark:bg-zinc-800 px-4 py-2 border-y border-zinc-200 dark:border-zinc-700 flex items-center gap-2 mt-2 border-t-0">
                        <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span class="text-xs uppercase tracking-wider font-bold text-black dark:text-white">Contact</span>
                    </div>

                    <!-- Contact List -->
                    <div class="px-4 bg-white dark:bg-zinc-900 divide-y divide-gray-100 text-sm pb-2">
                        <div class="py-3.5 flex items-center justify-between overflow-hidden">
                            <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium mr-4">Phone</span>
                            <span class="text-zinc-900 dark:text-zinc-100 w-2/3 font-medium text-[13px] truncate" x-text="viewMember.contact || ''"></span>
                        </div>
                        <div class="py-3.5 flex items-center justify-between overflow-hidden">
                            <span class="text-zinc-400 dark:text-zinc-500 w-1/3 text-[13px] font-medium mr-4">Email</span>
                            <span class="text-zinc-900 dark:text-zinc-100 w-2/3 font-medium text-[13px] truncate" x-text="viewMember.email || ''"></span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Navigation Bar Dummy -->
               
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Member?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    let currentStream = null;

    function initCamera(videoElement) {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                currentStream = stream;
                videoElement.srcObject = stream;
                videoElement.play();
            }).catch(function(err) {
                console.error("Camera access denied:", err);
                alert("Could not access camera. Please check permissions.");
            });
        } else {
            alert("Camera API is not supported in this browser.");
        }
    }

    function stopCamera(videoElement) {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            videoElement.srcObject = null;
            currentStream = null;
        }
    }

    function captureImage(videoElement, canvasElement) {
        const width = videoElement.videoWidth;
        const height = videoElement.videoHeight;
        
        // Square aspect ratio crop
        const size = Math.min(width, height);
        const startX = (width - size) / 2;
        const startY = (height - size) / 2;

        canvasElement.width = 400; // standard out size
        canvasElement.height = 400;
        const context = canvasElement.getContext('2d');
        
        context.drawImage(videoElement, startX, startY, size, size, 0, 0, 400, 400);
        return canvasElement.toDataURL('image/png'); // returns base64
    }
</script>
@endpush
@endsection
