<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class ExpiringSoonController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;
        $members = Member::where('gym_id', $gymId)
            ->whereBetween('fee_due_date', [now(), now()->addDays(3)])
            ->latest()
            ->paginate(12);

        return view('gym.expiring-soon.index', compact('members'));
    }
}
