<x-app-layout>
    @section('title', '| Order #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('dashboard.orders') }}" class="text-sm font-bold text-gray-500 hover:text-brand-black transition-colors mb-2 inline-block">← Back to Orders</a>
                <h1 class="text-3xl font-display font-black uppercase italic tracking-tight text-brand-black">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
            </div>
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'confirmed' => 'bg-blue-100 text-blue-800',
                    'crafting' => 'bg-purple-100 text-purple-800',
                    'quality_check' => 'bg-orange-100 text-orange-800',
                    'shipped' => 'bg-indigo-100 text-indigo-800',
                    'delivered' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                ];
            @endphp
            <span class="inline-flex px-4 py-1.5 rounded-full text-sm font-bold uppercase {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ str_replace('_', ' ', ucfirst($order->status)) }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-4">Items</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                            <div class="w-20 h-20 bg-brand-offwhite rounded-xl flex items-center justify-center flex-shrink-0">
                                <img src="{{ asset('images/shoe_' . ($item->shoe->model_type ?? 'low') . '.png') }}" class="w-14 h-14 object-contain mix-blend-darken">
                            </div>
                            <div class="flex-grow">
                                <p class="font-bold text-brand-black">{{ $item->shoe->name ?? 'Custom Shoe' }}</p>
                                <p class="text-xs text-gray-500">Size {{ $item->size }} × {{ $item->quantity }}</p>
                                @if(is_array($item->design_snapshot))
                                <div class="flex space-x-1 mt-1">
                                    @foreach(collect($item->design_snapshot)->filter(fn($v) => str_starts_with((string)$v, '#'))->take(6) as $color)
                                        <div class="w-4 h-4 rounded-full border border-gray-300" style="background-color: {{ $color }}"></div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <p class="font-bold text-brand-black">${{ number_format($item->price_snapshot * $item->quantity, 2) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tracking Timeline -->
                @if($order->tracking->count() > 0)
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-4">Order Timeline</h3>
                    <div class="space-y-4">
                        @foreach($order->tracking->sortByDesc('created_at') as $track)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 rounded-full bg-green-500 flex-shrink-0 mt-1.5"></div>
                                @if(!$loop->last)<div class="w-0.5 bg-gray-200 flex-grow mt-1"></div>@endif
                            </div>
                            <div class="pb-4">
                                <p class="font-bold text-brand-black text-sm capitalize">{{ str_replace('_', ' ', $track->status) }}</p>
                                <p class="text-xs text-gray-500">{{ $track->created_at->format('M d, Y \\a\\t h:i A') }}</p>
                                @if($track->note)<p class="text-sm text-gray-600 mt-1">{{ $track->note }}</p>@endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Summary -->
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-4">Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm"><span class="text-gray-500">Subtotal</span><span class="font-bold">${{ number_format($order->subtotal, 2) }}</span></div>
                        @if($order->discount > 0)
                        <div class="flex justify-between text-sm"><span class="text-green-600">Discount</span><span class="font-bold text-green-600">-${{ number_format($order->discount, 2) }}</span></div>
                        @endif
                        <div class="flex justify-between text-sm"><span class="text-gray-500">Shipping</span><span class="font-bold">{{ $order->delivery_fee > 0 ? '$' . number_format($order->delivery_fee, 2) : 'FREE' }}</span></div>
                        <div class="border-t border-gray-100 pt-3 mt-3 flex justify-between"><span class="font-bold text-brand-black">Total</span><span class="font-black text-xl text-brand-black">${{ number_format($order->total, 2) }}</span></div>
                    </div>
                </div>

                <!-- Shipping -->
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <h3 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-3">Shipping To</h3>
                    <p class="text-brand-black font-medium text-sm">{{ $order->shipping_address }}</p>
                    <p class="text-gray-500 text-sm">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                    <p class="text-gray-500 text-sm">{{ $order->shipping_country }}</p>
                    @if($order->shipping_phone)<p class="text-gray-500 text-sm mt-2">{{ $order->shipping_phone }}</p>@endif
                </div>

                <p class="text-xs text-gray-400 text-center">Placed on {{ $order->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
