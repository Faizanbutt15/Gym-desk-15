@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-100">Expired Members</h1>
        <p class="text-xs text-zinc-500 mt-0.5">{{ $members->total() }} {{ Str::plural('Member', $members->total()) }} whose fee is overdue</p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
        @forelse($members as $member)
            @php
                $daysOverdue = now()->startOfDay()->diffInDays($member->fee_due_date, false) * -1;
            @endphp
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 flex flex-col h-full transform transition hover:-translate-y-1 relative z-0 hover:z-10">
                <!-- Dark Header -->
                <div class="bg-black pt-6 pb-5 px-4 flex flex-col items-center rounded-t-2xl">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" class="w-32 h-32 rounded-full object-cover border-2 border-white shadow-sm mb-3">
                    @else
                        <div class="w-32 h-32 rounded-full bg-red-50 text-red-700 flex items-center justify-center font-bold text-5xl border-2 border-white shadow-sm mb-3">
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
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-bold border bg-red-600 text-white border-red-200">
                                Expired {{ $daysOverdue }} days ago
                            </span>
                        </div>
                        <div class="py-3 flex justify-between items-center bg-gray-50 -mx-4 px-4 border-b border-gray-100">
                            <span class="text-gray-500 font-bold text-[13px]">Gym Fee</span>
                            <span class="text-gray-900 font-bold">${{ number_format($member->fee_amount, 2) }}</span>
                        </div>
                        @if($member->trainer_fee > 0)
                        <div class="py-2.5 flex justify-between items-center text-[13px]">
                            <span class="text-gray-400 font-medium">Trainer Fee</span>
                            <span class="text-blue-600 font-bold">${{ number_format($member->trainer_fee, 2) }}</span>
                        </div>
                        @endif
                        @if($member->locker_fee > 0)
                        <div class="py-2.5 flex justify-between items-center text-[13px]">
                            <span class="text-gray-400 font-medium">Locker Fee</span>
                            <span class="text-purple-600 font-bold">${{ number_format($member->locker_fee, 2) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Section Header -->
                     

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
                    <div class="mt-auto px-5 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl relative z-20">
                        <form method="POST" action="{{ route('members.markPaid', $member) }}" class="block w-full space-y-4" onsubmit="window.confirmFormSubmit(event, this, 'Record Payment?', 'This will record a payment and extend the due date.', 'Yes, Mark as Paid')">
                            @csrf
                            
                            @php
                                $monthlyTotal = $member->fee_amount + $member->trainer_fee + $member->locker_fee;
                                $feeOptions = [
                                    1 => ['label' => '1 Month', 'amount' => $monthlyTotal],
                                    2 => ['label' => '2 Months', 'amount' => $monthlyTotal * 2],
                                    3 => ['label' => '3 Months', 'amount' => $monthlyTotal * 3],
                                    6 => ['label' => '6 Months', 'amount' => $monthlyTotal * 6],
                                    12 => ['label' => '1 Year', 'amount' => $monthlyTotal * 12],
                                ];
                            @endphp
                            
                            <div x-data="{ open: false, selected: 1, selectedLabel: '1 Month &mdash; ${{ number_format($monthlyTotal, 2) }}' }" class="relative z-40">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Months Paying For</label>
                                <input type="hidden" name="months" x-model="selected">
                                
                                <button type="button" @click="open = !open" @click.away="open = false" 
                                    class="relative w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 rounded-xl text-sm font-semibold text-left focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all shadow-sm flex items-center justify-between hover:border-gray-300">
                                    <span x-html="selectedLabel"></span>
                                    <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute top-full mt-2 w-full bg-white rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50" 
                                     style="display: none;">
                                    <ul class="max-h-60 overflow-y-auto text-sm divide-y divide-gray-50 p-1">
                                        @foreach($feeOptions as $val => $opt)
                                        <li @click="selected = {{ $val }}; selectedLabel = '{{ $opt['label'] }} &mdash; ${{ number_format($opt['amount'], 2) }}'; open = false"
                                            class="px-3 py-2.5 rounded-lg hover:bg-green-50 cursor-pointer transition-colors flex justify-between items-center group font-medium"
                                            :class="{'bg-green-50 text-green-700': selected == {{ $val }}, 'text-gray-600': selected != {{ $val }}}">
                                            <span :class="{'font-bold text-green-700': selected == {{ $val }}}">{{ $opt['label'] }}</span>
                                            <span class="text-gray-400 group-hover:text-green-600 transition-colors" :class="{'text-green-600 font-bold': selected == {{ $val }}}">${{ number_format($opt['amount'], 2) }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <button type="submit" class="relative z-10 w-full text-white bg-green-500 hover:bg-green-600 py-3 rounded-xl text-sm font-bold uppercase tracking-widest transition shadow-[0_4px_14px_0_rgba(34,197,94,0.39)] hover:shadow-[0_6px_20px_rgba(34,197,94,0.23)] hover:-translate-y-0.5 text-center flex justify-center items-center gap-2">
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
