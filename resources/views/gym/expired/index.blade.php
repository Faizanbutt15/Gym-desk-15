@extends('layouts.gym')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Expired Members</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $members->total() }} Members whose fee is overdue</p>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($members as $member)
            @php
                $daysOverdue = now()->startOfDay()->diffInDays($member->fee_due_date, false) * -1;
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden hover:shadow-md transition">
                <div class="p-5 flex flex-col h-full relative">
                    <div class="absolute top-0 right-0 w-16 h-16 pointer-events-none">
                        <div class="absolute inset-0 bg-red-50 opacity-50 rounded-bl-full"></div>
                    </div>
                    
                    <div class="flex items-start justify-between mb-4 relative z-10">
                        <div class="flex items-center gap-4">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" class="w-14 h-14 rounded-full object-cover border border-red-200 shadow-sm">
                            @else
                                <div class="w-14 h-14 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold text-xl border border-red-200 shadow-sm">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $member->name }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border mt-1 bg-red-100 text-red-800 border-red-200">
                                    Expired {{ $daysOverdue }} days ago
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-600 gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $member->contact ?? 'No contact' }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600 gap-2 overflow-hidden text-ellipsis whitespace-nowrap">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $member->email ?? 'No email' }}
                        </div>
                        <div class="flex items-center text-sm font-semibold text-gray-800 gap-2 pt-2 border-t border-gray-50 mt-2">
                            Due Amount: ${{ number_format($member->fee_amount, 2) }}
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        <form method="POST" action="{{ route('members.markPaid', $member) }}" class="block w-full">
                            @csrf
                            <button type="submit" class="w-full text-white bg-green-500 hover:bg-green-600 py-2.5 rounded-lg text-sm font-bold uppercase tracking-wide transition shadow-sm text-center flex justify-center items-center gap-2" onclick="return confirm('Mark as Paid? This will record a payment and reactivate the member.')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Capture Payment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-gray-500 bg-white rounded-xl border border-gray-100">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-green-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-xl font-medium text-gray-800">Great job!</span>
                    <p class="text-gray-500 mt-2">No members have currently expired.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($members->hasPages())
    <div class="py-4">
        {{ $members->links() }}
    </div>
    @endif
</div>
@endsection
