<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Order::whereNotIn('status', ['cancelled', 'refunded'])->sum('total');
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalUsers', 'pendingOrders', 'recentOrders'));
    }

    public function orders(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);
        $currentStatus = $request->status ?? 'all';

        return view('admin.orders', compact('orders', 'currentStatus'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,crafting,quality_check,shipped,out_for_delivery,delivered,cancelled,return_initiated,returned,refunded',
        ]);

        $order->update(['status' => $request->status]);

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'note' => $request->note ?? 'Status updated to ' . str_replace('_', ' ', $request->status) . '.',
        ]);

        return back()->with('success', 'Order status updated.');
    }
}
