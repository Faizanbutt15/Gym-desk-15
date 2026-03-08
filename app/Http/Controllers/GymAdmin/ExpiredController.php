<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class ExpiredController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;

        // Auto-move members expired > 60 days to inactive
        Member::where('gym_id', $gymId)
            ->where('status', 'active')
            ->whereNotNull('fee_due_date')
            ->where('fee_due_date', '<', now()->subDays(60))
            ->update(['status' => 'inactive']);

        $members = Member::where('gym_id', $gymId)
            ->where('fee_due_date', '<', now())
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('gym.expired.index', compact('members'));
    }
}
