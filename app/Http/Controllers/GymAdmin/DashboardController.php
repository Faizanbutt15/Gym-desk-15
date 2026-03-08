<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Payment;
use App\Models\StaffPayment;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
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

        // Member stats
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

        // Revenue stats
        $revenueThisMonth = Payment::where('gym_id', $gymId)
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->sum('amount');

        $totalRevenue = Payment::where('gym_id', $gymId)->sum('amount');

        $staffSpendingThisMonth = StaffPayment::where('gym_id', $gymId)
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->sum('amount');
            
        $expensesThisMonth = Expense::where('gym_id', $gymId)
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');
            
        $spendingThisMonth = $staffSpendingThisMonth + $expensesThisMonth;

        $totalStaffSpending = StaffPayment::where('gym_id', $gymId)->sum('amount');
        $totalExpenses = Expense::where('gym_id', $gymId)->sum('amount');
        $totalSpending = $totalStaffSpending + $totalExpenses;

        $netThisMonth = $revenueThisMonth - $spendingThisMonth;
        $netTotal     = $totalRevenue - $totalSpending;

        // Count unique members who made a payment this month
        $paidMembersThisMonth = Payment::where('gym_id', $gymId)
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->whereHas('member', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->distinct('member_id')
            ->count('member_id');

        $recentPayments = Payment::where('gym_id', $gymId)->latest()->take(8)->get();

        return view('gym.dashboard', compact(
            'totalMembers', 'activeMembers', 'inactiveMembers',
            'expiringSoon', 'expired', 'newMembersThisMonth',
            'revenueThisMonth', 'totalRevenue',
            'spendingThisMonth', 'totalSpending',
            'netThisMonth', 'netTotal',
            'paidMembersThisMonth', 'recentPayments'
        ));
    }
}
