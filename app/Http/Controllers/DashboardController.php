<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShoeDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ordersCount = Order::where('user_id', $user->id)->count();
        $designsCount = ShoeDesign::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)->whereNotIn('status', ['cancelled', 'refunded'])->sum('total');
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard', compact('user', 'ordersCount', 'designsCount', 'totalSpent', 'recentOrders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('dashboard.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.shoe', 'tracking']);
        return view('dashboard.order-detail', compact('order'));
    }

    public function designs()
    {
        $designs = ShoeDesign::where('user_id', Auth::id())->with('shoe')->latest()->paginate(12);
        return view('dashboard.designs', compact('designs'));
    }
}
