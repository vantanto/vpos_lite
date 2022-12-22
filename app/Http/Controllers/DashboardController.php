<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dateStart = Carbon::now()->startOfDay();
        $dateEnd = Carbon::now()->endOfDay();
        $dateStartMonth = Carbon::now()->startOfMonth();

        $newOrder = Order::whereBetween('date', [$dateStart, $dateEnd])
            ->count();
        $totalOrder = Order::whereBetween('date', [$dateStart, $dateEnd])
            ->sum('total');
        $newPurchase = Purchase::whereBetween('date', [$dateStart, $dateEnd])
            ->count();
        $newCustomer = Customer::whereBetween('created_at', [$dateStartMonth, $dateEnd])
            ->count();
        
        return view('dashboard', compact('newOrder', 'totalOrder', 'newPurchase', 'newCustomer'));
    }
}
