<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\StaffPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;

        // Income (Member Payments)
        $totalRevenue = Payment::where('gym_id', $gymId)->sum('amount');
        $revenueThisMonth = Payment::where('gym_id', $gymId)
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->sum('amount');
        $revenueThisYear = Payment::where('gym_id', $gymId)
            ->whereYear('paid_date', now()->year)
            ->sum('amount');
            
        // Spending (Staff Payments)
        $totalSpending = StaffPayment::where('gym_id', $gymId)->sum('amount');
        $spendingThisMonth = StaffPayment::where('gym_id', $gymId)
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->sum('amount');
        $spendingThisYear = StaffPayment::where('gym_id', $gymId)
            ->whereYear('paid_date', now()->year)
            ->sum('amount');
            
        // Net Revenue
        $netTotal = $totalRevenue - $totalSpending;
        $netThisMonth = $revenueThisMonth - $spendingThisMonth;
        $netThisYear = $revenueThisYear - $spendingThisYear;
            
        $paidMembersThisMonth = Payment::where('gym_id', $gymId)
            ->whereMonth('paid_date', now()->month)
            ->whereYear('paid_date', now()->year)
            ->distinct('member_id')
            ->count('member_id');

        $recentPayments = Payment::where('gym_id', $gymId)->latest()->take(10)->get();

        return view('gym.revenue.index', compact(
            'totalRevenue', 'revenueThisMonth', 'revenueThisYear', 
            'totalSpending', 'spendingThisMonth', 'spendingThisYear',
            'netTotal', 'netThisMonth', 'netThisYear',
            'paidMembersThisMonth', 'recentPayments'
        ));
    }

    public function chartData(Request $request)
    {
        $gymId = $request->user()->gym_id;
        $type = $request->input('type', 'day'); // day, month, year
        
        $data = [];
        $categories = [];

        if ($type === 'day') {
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $sum = Payment::where('gym_id', $gymId)
                    ->whereDate('paid_date', $date->format('Y-m-d'))
                    ->sum('amount');
                $categories[] = $date->format('M d');
                $data[] = (float) $sum;
            }
        } elseif ($type === 'month') {
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $sum = Payment::where('gym_id', $gymId)
                    ->whereMonth('paid_date', $date->month)
                    ->whereYear('paid_date', $date->year)
                    ->sum('amount');
                $categories[] = $date->format('M Y');
                $data[] = (float) $sum;
            }
        } elseif ($type === 'year') {
            $years = Payment::where('gym_id', $gymId)
                ->selectRaw('YEAR(paid_date) as year, SUM(amount) as total')
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
            foreach ($years as $row) {
                $categories[] = $row->year;
                $data[] = (float) $row->total;
            }
        }

        return response()->json([
            'categories' => $categories,
            'data' => $data
        ]);
    }
}
