<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;
        
        $totalMembers = Member::where('gym_id', $gymId)->count();
        $activeMembers = Member::where('gym_id', $gymId)->where('status', 'active')->count();
        $inactiveMembers = Member::where('gym_id', $gymId)->where('status', 'inactive')->count();
        
        $expiringSoon = Member::where('gym_id', $gymId)
            ->whereBetween('fee_due_date', [now(), now()->addDays(3)])
            ->count();
            
        $expired = Member::where('gym_id', $gymId)
            ->where('fee_due_date', '<', now())
            ->where('status', 'active')
            ->count();
            
        $newMembersThisMonth = Member::where('gym_id', $gymId)
            ->whereYear('joined_date', now()->year)
            ->whereMonth('joined_date', now()->month)
            ->count();
            
        return view('gym.dashboard', compact(
            'totalMembers', 'activeMembers', 'inactiveMembers', 'expiringSoon', 'expired', 'newMembersThisMonth'
        ));
    }
}
