@extends('layouts.gym')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Inactive Members</h1>
        <div class="flex items-center gap-3">
            <form action="{{ route('inactive-members') }}" method="GET" class="relative flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <select name="filter" onchange="this.form.submit()" class="border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary shadow-sm">
                    <option value="">All Inactive</option>
                    <option value="1_month" {{ request('filter') == '1_month' ? 'selected' : '' }}>1 Month Inactive</option>
                    <option value="2_months" {{ request('filter') == '2_months' ? 'selected' : '' }}>2 Months Inactive</option>
                    <option value="3_months_plus" {{ request('filter') == '3_months_plus' ? 'selected' : '' }}>3+ Months Inactive</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-medium">Member</th>
                        <th class="px-6 py-4 font-medium">Contact</th>
                        <th class="px-6 py-4 font-medium">Last Fee Due</th>
                        <th class="px-6 py-4 font-medium">Days Inactive</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $member)
                        @php
                            $daysInactive = $member->fee_due_date ? now()->startOfDay()->diffInDays($member->fee_due_date, false) * -1 : 0;
                            if($daysInactive < 0) $daysInactive = 0;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 grayscale">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center font-bold border border-gray-200">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-gray-900 font-semibold">{{ $member->name }}</div>
                                    <div class="text-gray-500 text-xs font-normal">{{ $member->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $member->contact ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $member->fee_due_date ? $member->fee_due_date->format('M d, Y') : 'Unknown' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $daysInactive }} days
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <form method="POST" action="{{ route('members.reactivate', $member) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white bg-primary hover:bg-blue-800 px-3 py-1.5 rounded textxs font-bold uppercase tracking-wide transition shadow-sm" onclick="return confirm('Reactivate this member?')">Reactivate</button>
                                </form>
                                <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline" id="delete-form-{{ $member->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $member->id }}')" class="text-red-500 hover:text-red-700 font-medium px-2 border-l border-gray-200">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="text-lg font-medium">No Inactive Members Found</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
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
