<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Member;
use App\Models\Staff;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;
        $date = $request->input('date', date('Y-m-d'));
        
        // Members Attendance for the day
        $members = Member::where('gym_id', $gymId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
            
        $memberAttendances = Attendance::where('gym_id', $gymId)
            ->where('date', $date)
            ->where('user_type', 'member')
            ->pluck('time_in', 'user_id')
            ->toArray();
            
        // Staff Attendance for the day
        $staffs = Staff::where('gym_id', $gymId)
            ->orderBy('name')
            ->get();
            
        $staffAttendances = Attendance::where('gym_id', $gymId)
            ->where('date', $date)
            ->where('user_type', 'staff')
            ->pluck('time_in', 'user_id')
            ->toArray();

        return view('gym.attendance.index', compact('members', 'memberAttendances', 'staffs', 'staffAttendances', 'date'));
    }

    public function store(Request $request)
    {
        $gymId = $request->user()->gym_id;

        $validated = $request->validate([
            'user_type' => 'required|in:member,staff',
            'user_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        // Check if already checked in today
        $exists = Attendance::where('gym_id', $gymId)
            ->where('user_type', $validated['user_type'])
            ->where('user_id', $validated['user_id'])
            ->where('date', $validated['date'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['message' => 'User is already checked in for this date.']);
        }

        Attendance::create([
            'gym_id' => $gymId,
            'user_type' => $validated['user_type'],
            'user_id' => $validated['user_id'],
            'date' => $validated['date'],
            'time_in' => now()->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }
}
