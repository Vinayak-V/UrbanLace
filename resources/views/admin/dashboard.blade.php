<x-admin-layout>
    <h1 class="text-3xl font-display font-black uppercase italic tracking-tight text-brand-black mb-8">Admin Dashboard</h1>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white border border-gray-100 rounded-xl p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Total Revenue</p>
            <p class="text-3xl font-black text-brand-black">${{ number_format($totalRevenue, 0) }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Total Orders</p>
            <p class="text-3xl font-black text-brand-black">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Total Users</p>
            <p class="text-3xl font-black text-brand-black">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Pending Orders</p>
            <p class="text-3xl font-black text-yellow-600">{{ $pendingOrders }}</p>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400">Recent Orders</h3>
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-green-500 hover:text-brand-black transition-colors">View All →</a>
        </div>
        <table class="w-full">
            <thead>
                <tr class="bg-brand-offwhite">
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Order</th>
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Customer</th>
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Date</th>
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Status</th>
                    <th class="text-right text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Total</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr class="border-t border-gray-50 hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold text-brand-black text-sm">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.updateOrderStatus', $order->id) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs font-bold uppercase border-gray-300 rounded py-1 px-2 focus:ring-green-500 focus:border-green-500">
                                @foreach(['pending','confirmed','crafting','quality_check','shipped','out_for_delivery','delivered','cancelled','refunded'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($s)) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-brand-black text-sm">${{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-4 text-right">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
