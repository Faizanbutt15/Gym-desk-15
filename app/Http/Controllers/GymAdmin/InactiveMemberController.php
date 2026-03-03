<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class InactiveMemberController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;
        
        $query = Member::where('gym_id', $gymId)
            ->where(function($q) {
                $q->where('status', 'inactive')
                  ->orWhere('fee_due_date', '<', now()->subDays(90));
            });

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('filter')) {
            if ($request->filter == '1_month') {
                $query->where('fee_due_date', '>=', now()->subDays(60))->where('fee_due_date', '<', now()->subDays(30));
            } elseif ($request->filter == '2_months') {
                $query->where('fee_due_date', '>=', now()->subDays(90))->where('fee_due_date', '<', now()->subDays(60));
            } elseif ($request->filter == '3_months_plus') {
                $query->where('fee_due_date', '<', now()->subDays(90));
            }
        }

        $members = $query->latest()->paginate(10)->withQueryString();

        return view('gym.inactive-members.index', compact('members'));
    }
}
