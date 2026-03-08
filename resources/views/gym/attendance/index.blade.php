@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-100">Daily Attendance Log</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Track member and staff check-ins</p>
        </div>
        <form action="{{ route('attendance.index') }}" method="GET"
              class="flex items-center gap-2 bg-white dark:bg-zinc-900 p-2 rounded-lg border border-zinc-200 dark:border-zinc-800 self-start sm:self-auto">
            <label class="text-xs font-medium text-zinc-500 dark:text-zinc-400 pl-1 whitespace-nowrap">Date:</label>
            <input type="date" name="date" value="{{ $date }}"
                   class="bg-zinc-50 dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 rounded-md text-sm focus:ring-red-500 focus:border-red-500"
                   onchange="this.form.submit()">
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Members Panel --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden flex flex-col" style="height: clamp(320px, 60vh, 70vh);">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/50">
                <h2 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Members</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <ul class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($members as $member)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <div class="flex items-center gap-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-10 h-10 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400 flex items-center justify-center font-bold text-sm border border-red-100 dark:border-red-900/40">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-zinc-900 dark:text-zinc-100 font-semibold text-sm">
                                        {{ $member->name }}
                                        <span class="text-xs text-zinc-400 font-normal ml-1">#{{ $member->member_id ?? 'N/A' }}</span>
                                    </div>
                                    <div class="text-xs text-zinc-500">Fee Next Due: {{ $member->fee_due_date ? $member->fee_due_date->format('M d') : 'N/A' }}</div>
                                </div>
                            </div>

                            <div>
                                @if(array_key_exists($member->id, $memberAttendances))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/50">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ \Carbon\Carbon::parse($memberAttendances[$member->id])->format('h:i A') }}
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('attendance.store') }}">
                                        @csrf
                                        <input type="hidden" name="user_type" value="member">
                                        <input type="hidden" name="user_id" value="{{ $member->id }}">
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        @if($date > date('Y-m-d'))
                                            <button type="submit" disabled class="px-3 py-1.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-400 rounded-lg text-xs font-bold opacity-50 cursor-not-allowed">Mark Present</button>
                                        @else
                                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition shadow-sm">Mark Present</button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400 text-sm">No active members found.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Staff Panel --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden flex flex-col" style="height: clamp(320px, 60vh, 70vh);">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/50">
                <h2 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Staff</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <ul class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($staffs as $staff)
                        <li class="px-6 py-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <div class="flex items-center gap-3">
                                @if($staff->photo)
                                    <img src="{{ asset('storage/' . $staff->photo) }}" class="w-10 h-10 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 flex items-center justify-center font-bold text-sm border border-zinc-200 dark:border-zinc-700">
                                        {{ substr($staff->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-zinc-900 dark:text-zinc-100 font-semibold text-sm">{{ $staff->name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $staff->role }}</div>
                                </div>
                            </div>

                            <div>
                                @if(array_key_exists($staff->id, $staffAttendances))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/50">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ \Carbon\Carbon::parse($staffAttendances[$staff->id])->format('h:i A') }}
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('attendance.store') }}">
                                        @csrf
                                        <input type="hidden" name="user_type" value="staff">
                                        <input type="hidden" name="user_id" value="{{ $staff->id }}">
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        @if($date > date('Y-m-d'))
                                            <button type="submit" disabled class="px-3 py-1.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-400 rounded-lg text-xs font-bold opacity-50 cursor-not-allowed">Mark Present</button>
                                        @else
                                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition shadow-sm">Mark Present</button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400 text-sm">No staff members found.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
