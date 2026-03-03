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
        $gymRevenues = Gym::withSum('payments', 'amount')->orderByDesc('payments_sum_amount')->get();

        $chartData = $gymRevenues->map(function ($gym) {
            return [
                'name' => $gym->name,
                'data' => [ (float) $gym->payments_sum_amount ]
            ];
        });

        $chartCategories = ['Revenue'];

        return view('superadmin.revenue.index', compact('gymRevenues', 'chartData', 'chartCategories'));
    }
}
