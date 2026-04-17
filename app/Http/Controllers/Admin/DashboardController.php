<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'restaurants' => Restaurant::query()->count(),
            'dishes' => Dish::query()->count(),
            'users' => User::query()->count(),
            'orders' => Order::query()->count(),
            'new_orders' => Order::query()->where('status', 'new')->count(),
        ];

        $recentOrders = Order::query()
            ->with(['user', 'restaurant'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }
}
