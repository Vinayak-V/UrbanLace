<x-admin-layout>
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-display font-black uppercase italic tracking-tight text-brand-black">All Orders</h1>
    </div>

    <!-- Status Filter Tabs -->
    <div class="flex space-x-2 mb-6 bg-white p-1.5 rounded-full border border-gray-100 inline-flex overflow-x-auto">
        @php
            $statuses = ['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'crafting' => 'Crafting', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
        @endphp
        @foreach($statuses as $key => $label)
            <a href="{{ route('admin.orders', ['status' => $key]) }}"
               class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-colors whitespace-nowrap {{ $currentStatus === $key ? 'bg-brand-black text-white' : 'text-gray-500 hover:text-brand-black' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Orders Table -->
    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-brand-offwhite">
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Order</th>
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Customer</th>
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Date</th>
                    <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Status</th>
                    <th class="text-right text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-t border-gray-50 hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold text-brand-black text-sm">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</td>
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
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $orders->appends(['status' => $currentStatus])->links() }}</div>
</x-admin-layout>
