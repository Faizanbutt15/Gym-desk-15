<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index()
    {
        // Calculate revenue from gymPayments (what the gym pays the Super Admin)
        $gymRevenues = Gym::withSum('gymPayments', 'amount')->orderByDesc('gym_payments_sum_amount')->get();

        $chartData = $gymRevenues->map(function ($gym) {
            return [
                'name' => $gym->name,
                'data' => [ (float) $gym->gym_payments_sum_amount ]
            ];
        });

        $chartCategories = ['Revenue'];

        return view('superadmin.revenue.index', compact('gymRevenues', 'chartData', 'chartCategories'));
    }
}
