<x-app-layout>
    @section('title', '| Cart')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-display font-black uppercase italic tracking-tight text-brand-black mb-8">Your Cart</h1>

        @if($items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($items as $item)
                <div class="bg-white border border-gray-100 rounded-xl p-6 flex items-center gap-6 group hover:shadow-md transition-shadow" id="cart-item-{{ $item->id }}">
                    <!-- Shoe Image -->
                    <div class="w-28 h-28 bg-brand-offwhite rounded-xl flex-shrink-0 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/shoe_' . ($item->shoe->model_type ?? 'low') . '.png') }}" class="w-4/5 h-4/5 object-contain mix-blend-darken">
                    </div>

                    <!-- Info -->
                    <div class="flex-grow min-w-0">
                        <h3 class="font-bold text-lg text-brand-black truncate">{{ $item->shoe->name ?? 'Custom Shoe' }}</h3>
                        <p class="text-sm text-gray-500 mb-2">Size: {{ $item->size }} | {{ ucfirst($item->shoe->model_type ?? 'low') }} Top</p>

                        <!-- Design color swatches -->
                        <div class="flex space-x-1.5">
                            @if(is_array($item->design_snapshot))
                                @foreach(collect($item->design_snapshot)->filter(fn($v) => str_starts_with((string)$v, '#'))->take(6) as $zone => $color)
                                    <div class="w-5 h-5 rounded-full border border-gray-300 shadow-inner" style="background-color: {{ $color }}" title="{{ ucfirst($zone) }}"></div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center space-x-2 flex-shrink-0">
                        <button onclick="updateQty({{ $item->id }}, -1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-lg font-bold">−</button>
                        <span id="qty-{{ $item->id }}" class="w-8 text-center font-bold text-brand-black">{{ $item->quantity }}</span>
                        <button onclick="updateQty({{ $item->id }}, 1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-lg font-bold">+</button>
                    </div>

                    <!-- Price -->
                    <div class="text-right flex-shrink-0 w-24">
                        <p class="font-black text-lg text-brand-black">${{ number_format($item->price_snapshot * $item->quantity, 2) }}</p>
                    </div>

                    <!-- Remove -->
                    <button onclick="removeItem({{ $item->id }})" class="text-gray-300 hover:text-red-500 transition-colors flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 rounded-xl p-6 sticky top-24">
                    <h3 class="font-bold text-lg uppercase tracking-wider text-brand-black mb-6">Order Summary</h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal ({{ $items->sum('quantity') }} items)</span>
                            <span id="summary-subtotal" class="font-bold text-brand-black">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Shipping</span>
                            <span class="font-medium text-green-600">Calculated at checkout</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex justify-between">
                            <span class="font-bold text-brand-black">Estimated Total</span>
                            <span id="summary-total" class="font-black text-xl text-brand-black">${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout.show') }}" class="w-full flex items-center justify-center px-6 py-4 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors rounded shadow-[2px_2px_0px_rgba(17,17,17,1)] active:shadow-none active:translate-y-0.5 active:translate-x-0.5">
                        Proceed to Checkout
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('products.index') }}" class="block text-center text-sm font-bold text-gray-500 hover:text-brand-black mt-4 transition-colors">Continue Shopping</a>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="text-center py-20">
            <svg class="mx-auto w-20 h-20 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <h2 class="text-2xl font-bold text-brand-black mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added any custom kicks yet.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-8 py-4 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors rounded shadow-[2px_2px_0px_rgba(17,17,17,1)]">
                Start Designing
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
        @endif
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        async function updateQty(itemId, delta) {
            const qtyEl = document.getElementById('qty-' + itemId);
            let newQty = parseInt(qtyEl.textContent) + delta;
            if (newQty < 1) newQty = 1;
            if (newQty > 10) newQty = 10;
            qtyEl.textContent = newQty;

            const res = await fetch(`/cart/${itemId}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ quantity: newQty })
            });
            if (res.ok) location.reload();
        }

        async function removeItem(itemId) {
            const res = await fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) {
                document.getElementById('cart-item-' + itemId)?.remove();
                location.reload();
            }
        }
    </script>
</x-app-layout>
