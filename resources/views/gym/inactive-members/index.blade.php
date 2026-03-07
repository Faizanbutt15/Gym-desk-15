@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-100">Inactive Members</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Members with no active payments</p>
        </div>
        <form action="{{ route('inactive-members') }}" method="GET" class="flex flex-col xs:flex-row items-start xs:items-center gap-2 w-full sm:w-auto">
            <div class="relative w-full sm:w-52">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name..."
                       class="pl-9 pr-4 py-2 bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full placeholder-zinc-400 dark:placeholder-zinc-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ph-bold ph-magnifying-glass text-zinc-400 dark:text-zinc-500 text-sm"></i>
                </div>
            </div>
            <select name="filter" onchange="this.form.submit()"
                    class="bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500 w-full sm:w-auto py-2 px-3">
                <option value="">All Inactive</option>
                <option value="1_month"      {{ request('filter') == '1_month'      ? 'selected' : '' }}>1 Month</option>
                <option value="2_months"     {{ request('filter') == '2_months'     ? 'selected' : '' }}>2 Months</option>
                <option value="3_months_plus"{{ request('filter') == '3_months_plus'? 'selected' : '' }}>3+ Months</option>
            </select>
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                    {{ $daysInactive }} days
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <form method="POST" action="{{ route('members.reactivate', $member) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-lg text-xs font-bold transition"
                                            onclick="return confirm('Reactivate this member?')">
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
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
@endsection
