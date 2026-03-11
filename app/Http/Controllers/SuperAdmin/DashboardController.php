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
        
        $totalRevenue = \App\Models\GymPayment::sum('amount');
        
        $recentGyms = Gym::latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalGyms', 'activeGyms', 'inactiveGyms', 'totalRevenue', 'recentGyms'
        ));
    }
}
