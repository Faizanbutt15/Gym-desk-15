@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-100">Inactive Members</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Members with no active payments</p>
        </div>
        <form action="{{ route('inactive-members') }}" method="GET" id="inactive-filter-form" class="flex flex-wrap items-center gap-2">
            {{-- Search --}}
            <div class="relative w-full sm:w-52">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name..."
                       class="pl-9 pr-4 py-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full placeholder-zinc-400 dark:placeholder-zinc-500 shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ph-bold ph-magnifying-glass text-zinc-400 dark:text-zinc-500 text-sm"></i>
                </div>
            </div>

            {{-- Duration Filter Dropdown --}}
            @php
                $selInactive = request('filter', '');
                $inactiveOptions = [
                    ''             => ['label' => 'All Inactive',  'icon' => 'ph-prohibit'],
                    '1_month'      => ['label' => '1 Month',       'icon' => 'ph-calendar'],
                    '2_months'     => ['label' => '2 Months',      'icon' => 'ph-calendar-blank'],
                    '3_months_plus'=> ['label' => '3+ Months',     'icon' => 'ph-warning-circle'],
                ];
                $selInactiveLabel = $inactiveOptions[$selInactive]['label'] ?? 'All Inactive';
            @endphp
            <div class="relative" x-data="{ open: false, selected: '{{ $selInactive }}' }" @click.outside="open = false">
                <button type="button" @click="open = !open"
                        class="flex items-center gap-2 pl-3.5 pr-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-200 text-sm font-medium shadow-sm hover:border-zinc-300 dark:hover:border-zinc-600 transition-all min-w-[140px]">
                    <i class="ph-bold ph-clock text-red-500" style="font-size:14px;"></i>
                    <span class="flex-1 text-left">{{ $selInactiveLabel }}</span>
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
                     class="absolute right-0 z-50 mt-1.5 w-44 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden">
                    <div class="py-1">
                        @foreach($inactiveOptions as $val => $opt)
                            <button type="button"
                                    @click="selected = '{{ $val }}'; open = false; $nextTick(() => document.getElementById('inactive-filter-form').submit())"
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
    </div>

    {{-- Members Table --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Member</th>
                        <th class="px-6 py-4 font-semibold">Contact</th>
                        <th class="px-6 py-4 font-semibold">Last Fee Due</th>
                        <th class="px-6 py-4 font-semibold">Days Inactive</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($members as $member)
                        @php
                            $daysInactive = $member->fee_due_date ? now()->startOfDay()->diffInDays($member->fee_due_date, false) * -1 : 0;
                            if($daysInactive < 0) $daysInactive = 0;
                        @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4 flex items-center gap-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}"
                                         class="w-10 h-10 rounded-full object-cover border border-zinc-200 dark:border-zinc-700 grayscale shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 flex items-center justify-center font-bold border border-zinc-200 dark:border-zinc-700 shrink-0">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-zinc-900 dark:text-zinc-100 font-semibold">{{ $member->name }}</div>
                                    <div class="text-zinc-500 text-xs font-normal">{{ $member->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                {{ $member->contact ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-zinc-500">
                                {{ $member->fee_due_date ? $member->fee_due_date->format('M d, Y') : 'Unknown' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-600 text-white">
                                    {{ $daysInactive }} days
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <form method="POST" action="{{ route('members.reactivate', $member) }}" class="inline" onsubmit="window.confirmFormSubmit(event, this, 'Reactivate Member?', 'This will reactivate the member profile.', 'Yes, Reactivate')">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="ph-bold ph-arrow-counter-clockwise" style="font-size:13px;"></i>
                                        Reactivate
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline" id="delete-form-{{ $member->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete('{{ $member->id }}')"
                                            class="text-white bg-red-500 hover:bg-red-700 p-1.5 rounded-lg transition border border-red-900/30" title="Delete">
                                        <i class="ph-bold ph-trash" style="font-size:14px;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-500">
                                <div class="flex flex-col items-center">
                                    <i class="ph-fill ph-prohibit text-zinc-300 dark:text-zinc-700 mb-3" style="font-size:48px;"></i>
                                    <span class="text-base font-medium text-zinc-500 dark:text-zinc-400">No Inactive Members Found</span>
                                    <p class="text-sm text-zinc-400 dark:text-zinc-600 mt-1">All members are currently active.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Inactive Member?',
            text: "This action cannot be undone.",
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
