@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-100">Daily Attendance Log</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Track member and staff check-ins</p>
        </div>
        <form action="{{ route('attendance.index') }}" method="GET" class="flex items-center gap-2 bg-zinc-900 p-2 rounded-lg border border-zinc-800 self-start sm:self-auto">
            <label class="text-xs font-medium text-zinc-400 pl-1 whitespace-nowrap">Date:</label>
            <input type="date" name="date" value="{{ $date }}" class="bg-zinc-800 border-zinc-700 text-zinc-200 rounded-md text-sm focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Members List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col" style="height: clamp(320px, 60vh, 70vh);">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800">Members</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <ul class="divide-y divide-gray-100">
                    @forelse($members as $member)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold text-sm border border-blue-200">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-gray-900 font-semibold text-sm">{{ $member->name }} <span class="text-xs text-gray-400 font-normal ml-1">#{{ $member->member_id ?? 'N/A' }}</span></div>
                                    <div class="text-xs text-gray-500">Fee Next Due: {{ $member->fee_due_date ? $member->fee_due_date->format('M d') : 'N/A' }}</div>
                                </div>
                            </div>
                            
                            <div>
                                @if(array_key_exists($member->id, $memberAttendances))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ \Carbon\Carbon::parse($memberAttendances[$member->id])->format('h:i A') }}
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('attendance.store') }}">
                                        @csrf
                                        <input type="hidden" name="user_type" value="member">
                                        <input type="hidden" name="user_id" value="{{ $member->id }}">
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        <button type="submit" @if($date > date('Y-m-d')) disabled class="px-3 py-1.5 bg-gray-200 text-gray-400 rounded-md text-xs font-bold opacity-50 cursor-not-allowed" @else class="px-3 py-1.5 bg-primary hover:bg-blue-800 text-white rounded-md text-xs font-bold transition shadow-sm" @endif>Mark Present</button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-gray-500 text-sm">No active members found.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Staff List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col" style="height: clamp(320px, 60vh, 70vh);">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800">Staff</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <ul class="divide-y divide-gray-100">
                    @forelse($staffs as $staff)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                @if($staff->photo)
                                    <img src="{{ asset('storage/' . $staff->photo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold text-sm border border-blue-200">
                                        {{ substr($staff->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-gray-900 font-semibold text-sm">{{ $staff->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $staff->role }}</div>
                                </div>
                            </div>
                            
                            <div>
                                @if(array_key_exists($staff->id, $staffAttendances))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ \Carbon\Carbon::parse($staffAttendances[$staff->id])->format('h:i A') }}
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('attendance.store') }}">
                                        @csrf
                                        <input type="hidden" name="user_type" value="staff">
                                        <input type="hidden" name="user_id" value="{{ $staff->id }}">
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        <button type="submit" @if($date > date('Y-m-d')) disabled class="px-3 py-1.5 bg-gray-200 text-gray-400 rounded-md text-xs font-bold opacity-50 cursor-not-allowed" @else class="px-3 py-1.5 bg-gray-800 hover:bg-black text-white rounded-md text-xs font-bold transition shadow-sm" @endif>Mark Present</button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-gray-500 text-sm">No staff members found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
