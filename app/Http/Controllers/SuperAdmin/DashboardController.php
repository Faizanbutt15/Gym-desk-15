<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGyms = Gym::count();
        $activeGyms = Gym::where('status', 'active')->count();
        $inactiveGyms = Gym::where('status', 'inactive')->count();
        $expiringSoonGyms = Gym::where('status', 'expiring_soon')->count();
        $expiredGyms = Gym::where('status', 'expired')->count();
        
        $totalRevenue = \App\Models\GymPayment::sum('amount');
        
        $revenueThisMonth = \App\Models\GymPayment::whereMonth('payment_date', now()->month)
                                                  ->whereYear('payment_date', now()->year)
                                                  ->sum('amount');
                                                  
        $revenueThisYear = \App\Models\GymPayment::whereYear('payment_date', now()->year)
                                                 ->sum('amount');
        
        $recentGyms = Gym::latest()->take(5)->get();
        
        $recentPayments = \App\Models\GymPayment::with('gym')
                                                ->latest('payment_date')
                                                ->take(5)
                                                ->get();

        return view('superadmin.dashboard', compact(
            'totalGyms', 'activeGyms', 'inactiveGyms', 'totalRevenue', 
            'recentGyms', 'revenueThisMonth', 'revenueThisYear', 'recentPayments',
            'expiringSoonGyms', 'expiredGyms'
        ));
    }

    public function chartData(Request $request)
    {
        $type = $request->input('type', 'day'); // day, month, year
        
        $data = [];
        $categories = [];

        if ($type === 'day') {
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $sum = \App\Models\GymPayment::whereDate('payment_date', $date->format('Y-m-d'))
                                               ->sum('amount');
                $categories[] = $date->format('M d');
                $data[] = (float) $sum;
            }
        } elseif ($type === 'month') {
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $sum = \App\Models\GymPayment::whereMonth('payment_date', $date->month)
                                               ->whereYear('payment_date', $date->year)
                                               ->sum('amount');
                $categories[] = $date->format('M Y');
                $data[] = (float) $sum;
            }
        } elseif ($type === 'year') {
            $years = \App\Models\GymPayment::selectRaw('YEAR(payment_date) as year, SUM(amount) as total')
                                             ->groupBy('year')
                                             ->orderBy('year', 'asc')
                                             ->get();
            foreach ($years as $row) {
                // To avoid breaking if the site is new and there's only 1 year, we can just display it.
                $categories[] = $row->year;
                $data[] = (float) $row->total;
            }
            
            // If no data, give at least current year
            if(empty($categories)) {
                $categories[] = now()->year;
                $data[] = 0;
            }
        }

        return response()->json([
            'categories' => $categories,
            'data' => $data
        ]);
    }
}
