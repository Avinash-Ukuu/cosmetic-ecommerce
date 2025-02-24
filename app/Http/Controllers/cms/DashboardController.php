<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $order                  =       new Order();
        $data['totalOrders']    =       $order->count();
        $data['totalRevenue']   =       $order->where('status', 'delivered')->sum('total_amount');
        $data['totalCustomers'] =       User::whereHas('roles', function($query){
                                            $query->where('name','customer');
                                        })->count();
        $data['totalProducts']  =       Product::count();
        $data['pendingOrders']  =       $order->where('status', 'pending')->count();
        $data['recentOrders']   =       $order->latest()->take(5)->get();

        $monthlySales = $order->selectRaw('MONTH(order_created_at) as month, SUM(total_amount) as total')
            ->whereYear('order_created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        // Convert to full 12-month array for Chart.js
        $salesData = array_fill(1, 12, 0);
        foreach ($monthlySales as $month => $total) {
            $salesData[$month] = $total;
        }
        $data['salesData']      =       $salesData;
        $data['monthlySales']   =       $monthlySales;


        return view('dashboard',$data);
    }
}
