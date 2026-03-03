@extends('layouts.gym')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Expiring Soon</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $members->total() }} Members Expiring within 3 days</p>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($members as $member)
            @php
                $daysLeft = now()->startOfDay()->diffInDays($member->fee_due_date, false);
                $badgeColor = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                $badgeText = $daysLeft . ' Days Left';
                
                if ($daysLeft == 0) {
                    $badgeColor = 'bg-red-100 text-red-800 border-red-200';
                    $badgeText = 'Expires Today';
                } elseif ($daysLeft == 1) {
                    $badgeColor = 'bg-orange-100 text-orange-800 border-orange-200';
                    $badgeText = '1 Day Left';
                }
            @endphp
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col h-full transform transition hover:-translate-y-1">
                <!-- Dark Header -->
                <div class="bg-black pt-6 pb-5 px-4 flex flex-col items-center">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" class="w-32 h-32 rounded-full object-cover border-2 border-white shadow-sm mb-3">
                    @else
                        <div class="w-32 h-32 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold text-5xl border-2 border-white shadow-sm mb-3">
                            {{ substr($member->name, 0, 1) }}
                        </div>
                    @endif
                    <h3 class="text-xl font-medium text-white tracking-wide text-center">{{ $member->name }}</h3>
                </div>
                
                <!-- Body -->
                <div class="flex-1 flex flex-col text-sm">
                    <!-- Section Header -->
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b border-gray-200">
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        <span class="text-xs uppercase tracking-wider font-bold text-black">Details</span>
                    </div>
                    
                    <div class="px-4 divide-y divide-gray-100">
                        <div class="py-3 flex justify-between items-center">
                            <span class="text-gray-400 font-medium">Status</span>
                            <span class="inline-flex items-center px-2 py-0.5 bg-yellow-300 text-white rounded-lg text-[11px] font-bold border {{ $badgeColor }}">
                                {{ $badgeText }}
                            </span>
                        </div>
                        <div class="py-3 flex justify-between items-center">
                            <span class="text-gray-400 font-medium">Due Amount</span>
                            <span class="text-gray-900 font-bold">${{ number_format($member->fee_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="px-4 divide-y divide-gray-100 pb-2">
                        <div class="py-3 flex justify-between items-center overflow-hidden">
                            <span class="text-gray-400 font-medium mr-4">Phone</span>
                            <span class="text-gray-900 truncate">{{ $member->contact ?? 'N/A' }}</span>
                        </div>
                        <div class="py-3 flex justify-between items-center overflow-hidden">
                            <span class="text-gray-400 font-medium mr-4">Email</span>
                            <span class="text-gray-900 truncate">{{ $member->email ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Action bottom -->
                    <div class="mt-auto px-4 bg-gray-50 border-t border-gray-200">
                        <form method="POST" action="{{ route('members.markPaid', $member) }}" class="block w-full space-y-3">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-black uppercase tracking-wider mb-1.5 pl-1">Months Paying For</label>
                                <select name="months" class="w-full text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 shadow-sm bg-white text-gray-700 py-2">
                                    <option value="1">1 Month (${{ number_format($member->fee_amount, 2) }})</option>
                                    <option value="2">2 Months (${{ number_format($member->fee_amount * 2, 2) }})</option>
                                    <option value="3">3 Months (${{ number_format($member->fee_amount * 3, 2) }})</option>
                                    <option value="6">6 Months (${{ number_format($member->fee_amount * 6, 2) }})</option>
                                    <option value="12">12 Months (${{ number_format($member->fee_amount * 12, 2) }})</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full text-white bg-green-500 hover:bg-green-600 py-2.5 rounded-lg text-sm font-bold uppercase tracking-widest transition shadow-md text-center flex justify-center items-center gap-2" onclick="return confirm('Record this payment and extend the due date?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Mark as Paid
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-gray-500 bg-white rounded-xl border border-gray-100">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-green-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-xl font-medium text-gray-800">All clear!</span>
                    <p class="text-gray-500 mt-2">No members are expiring soon.</p>
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
