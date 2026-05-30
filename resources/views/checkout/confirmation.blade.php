<x-app-layout>
    @section('title', '| Order Confirmed')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <!-- Success Icon -->
        <div class="mx-auto w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h1 class="text-4xl font-display font-black uppercase italic tracking-tight text-brand-black mb-3">Order Confirmed!</h1>
        <p class="text-lg text-gray-500 mb-2">Thank you for your order. Your custom sneakers are being crafted.</p>
        <p class="text-sm font-bold text-brand-black mb-10">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>

        <!-- Order Details -->
        <div class="bg-white border border-gray-100 rounded-xl p-6 text-left mb-8">
            <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-4">Order Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                    <div class="w-16 h-16 bg-brand-offwhite rounded-lg flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/shoe_' . ($item->shoe->model_type ?? 'low') . '.png') }}" class="w-12 h-12 object-contain mix-blend-darken">
                    </div>
                    <div class="flex-grow">
                        <p class="font-bold text-brand-black">{{ $item->shoe->name ?? 'Custom Shoe' }}</p>
                        <p class="text-xs text-gray-500">Size {{ $item->size }} × {{ $item->quantity }}</p>
                    </div>
                    <p class="font-bold text-brand-black">${{ number_format($item->price_snapshot * $item->quantity, 2) }}</p>
                </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-bold">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-green-600">Discount</span>
                    <span class="font-bold text-green-600">-${{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Shipping</span>
                    <span class="font-bold">{{ $order->delivery_fee > 0 ? '$' . number_format($order->delivery_fee, 2) : 'FREE' }}</span>
                </div>
                <div class="flex justify-between text-lg border-t border-gray-200 pt-3 mt-3">
                    <span class="font-bold text-brand-black">Total</span>
                    <span class="font-black text-brand-black">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="bg-white border border-gray-100 rounded-xl p-6 text-left mb-10">
            <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-3">Shipping To</h3>
            <p class="text-brand-black font-medium">{{ $order->shipping_address }}</p>
            <p class="text-gray-500">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
            <p class="text-gray-500">{{ $order->shipping_country }}</p>
        </div>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('dashboard.orders') }}" class="inline-flex items-center justify-center px-8 py-4 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors rounded shadow-[2px_2px_0px_rgba(17,17,17,1)]">
                View My Orders
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 text-sm font-black uppercase tracking-wider text-brand-black border-2 border-brand-black hover:bg-brand-black hover:text-white transition-colors rounded">
                Continue Shopping
            </a>
        </div>
    </div>
</x-app-layout>
