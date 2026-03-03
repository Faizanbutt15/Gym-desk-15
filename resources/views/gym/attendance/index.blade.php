@extends('layouts.gym')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Daily Attendance Log</h1>
        <form action="{{ route('attendance.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-lg shadow-sm border border-gray-100">
            <label class="text-sm font-medium text-gray-600 pl-2">Select Date:</label>
            <input type="date" name="date" value="{{ $date }}" class="border-gray-300 rounded-md text-sm focus:ring-primary focus:border-primary" onchange="this.form.submit()">
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Members List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-[70vh]">
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-[70vh]">
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
