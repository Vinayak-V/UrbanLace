<x-app-layout>
    @section('title', '| My Orders')

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-display font-black uppercase italic tracking-tight text-brand-black">My Orders</h1>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-brand-black transition-colors">← Dashboard</a>
        </div>

        @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <a href="{{ route('dashboard.orderDetail', $order->id) }}" class="block bg-white border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow no-underline">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-bold text-brand-black text-lg">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y \\a\\t h:i A') }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'crafting' => 'bg-purple-100 text-purple-800',
                                'quality_check' => 'bg-orange-100 text-orange-800',
                                'shipped' => 'bg-indigo-100 text-indigo-800',
                                'out_for_delivery' => 'bg-cyan-100 text-cyan-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'refunded' => 'bg-gray-100 text-gray-800',
                            ];
                        @endphp
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ str_replace('_', ' ', ucfirst($order->status)) }}</span>
                        <span class="font-black text-lg text-brand-black">${{ number_format($order->total, 2) }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
        @else
        <div class="text-center py-20 bg-white border border-gray-100 rounded-xl">
            <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <h2 class="text-xl font-bold text-brand-black mb-2">No orders yet</h2>
            <p class="text-gray-500 mb-6">Your order history will appear here.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 rounded transition-colors">Browse Models</a>
        </div>
        @endif
    </div>
</x-app-layout>
