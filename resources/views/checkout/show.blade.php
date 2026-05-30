<x-app-layout>
    @section('title', '| Checkout')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-display font-black uppercase italic tracking-tight text-brand-black mb-8">Checkout</h1>

        <form method="POST" action="{{ route('checkout.placeOrder') }}" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Left: Shipping Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Information -->
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <h3 class="font-bold text-lg uppercase tracking-wider text-brand-black mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-brand-black text-white flex items-center justify-center text-sm font-black mr-3">1</span>
                            Shipping Address
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Street Address</label>
                                <input type="text" name="shipping_address" required class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium text-sm" placeholder="123 Main Street, Apt 4">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">City</label>
                                <input type="text" name="shipping_city" required class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">State / Province</label>
                                <input type="text" name="shipping_state" class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ZIP / Postal Code</label>
                                <input type="text" name="shipping_zip" required class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Country</label>
                                <input type="text" name="shipping_country" required value="United States" class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Phone (Optional)</label>
                                <input type="text" name="shipping_phone" class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium text-sm" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Options -->
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <h3 class="font-bold text-lg uppercase tracking-wider text-brand-black mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-brand-black text-white flex items-center justify-center text-sm font-black mr-3">2</span>
                            Delivery Method
                        </h3>
                        <div class="space-y-3">
                            @foreach($deliveryOptions as $index => $option)
                            <label class="flex items-center p-4 rounded-lg border-2 cursor-pointer transition-colors peer-checked:border-green-500 hover:border-gray-300 {{ $index === 0 ? 'border-green-500 bg-green-50' : 'border-gray-200' }}" id="delivery-label-{{ $option->id }}">
                                <input type="radio" name="delivery_option_id" value="{{ $option->id }}" class="hidden peer" {{ $index === 0 ? 'checked' : '' }}
                                    onchange="selectDelivery({{ $option->id }}, {{ $option->price }})">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 mr-4 flex items-center justify-center flex-shrink-0" id="delivery-radio-{{ $option->id }}">
                                    @if($index === 0)<div class="w-3 h-3 rounded-full bg-green-500"></div>@endif
                                </div>
                                <div class="flex-grow">
                                    <p class="font-bold text-brand-black text-sm">{{ $option->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $option->description }} ({{ $option->estimated_days_min }}-{{ $option->estimated_days_max }} days)</p>
                                </div>
                                <span class="font-black text-brand-black ml-4">{{ $option->price > 0 ? '$' . number_format($option->price, 2) : 'FREE' }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <h3 class="font-bold text-lg uppercase tracking-wider text-brand-black mb-4 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-brand-black text-white flex items-center justify-center text-sm font-black mr-3">3</span>
                            Order Notes (Optional)
                        </h3>
                        <textarea name="notes" rows="3" class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium text-sm" placeholder="Any special instructions for your order..."></textarea>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white border border-gray-100 rounded-xl p-6 sticky top-24">
                        <h3 class="font-bold text-lg uppercase tracking-wider text-brand-black mb-6">Order Summary</h3>
                        
                        <!-- Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($items as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 bg-brand-offwhite rounded-lg flex items-center justify-center flex-shrink-0">
                                    <img src="{{ asset('images/shoe_' . ($item->shoe->model_type ?? 'low') . '.png') }}" class="w-10 h-10 object-contain mix-blend-darken">
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="text-sm font-bold text-brand-black truncate">{{ $item->shoe->name ?? 'Custom Shoe' }}</p>
                                    <p class="text-xs text-gray-500">Size {{ $item->size }} × {{ $item->quantity }}</p>
                                </div>
                                <p class="font-bold text-sm text-brand-black">${{ number_format($item->price_snapshot * $item->quantity, 2) }}</p>
                            </div>
                            @endforeach
                        </div>

                        <!-- Coupon -->
                        <div class="mb-6">
                            <div class="flex gap-2">
                                <input type="text" id="coupon-input" placeholder="Coupon code" class="flex-grow border-gray-300 rounded text-sm focus:ring-green-500 focus:border-green-500">
                                <button type="button" onclick="applyCoupon()" class="px-4 py-2 bg-brand-black text-white text-xs font-bold uppercase rounded hover:bg-gray-800 transition-colors">Apply</button>
                            </div>
                            <p id="coupon-msg" class="text-xs mt-1 hidden"></p>
                            <input type="hidden" name="coupon_id" id="coupon-id-input" value="">
                        </div>

                        <!-- Totals -->
                        <div class="space-y-3 border-t border-gray-100 pt-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-bold">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm" id="discount-row" style="display: none;">
                                <span class="text-green-600">Discount</span>
                                <span class="font-bold text-green-600" id="discount-amount">-$0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Shipping</span>
                                <span class="font-bold" id="shipping-cost">{{ $deliveryOptions[0]->price > 0 ? '$' . number_format($deliveryOptions[0]->price, 2) : 'FREE' }}</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between">
                                <span class="font-bold text-brand-black">Total</span>
                                <span class="font-black text-2xl text-brand-black" id="order-total">${{ number_format($subtotal + $deliveryOptions[0]->price, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center px-6 py-4 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors rounded shadow-[2px_2px_0px_rgba(17,17,17,1)] active:shadow-none active:translate-y-0.5 active:translate-x-0.5">
                            Place Order
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>

                        <a href="{{ route('cart.index') }}" class="block text-center text-sm font-bold text-gray-500 hover:text-brand-black mt-4 transition-colors">← Back to Cart</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const subtotal = {{ $subtotal }};
        let shippingCost = {{ $deliveryOptions[0]->price }};
        let discountAmount = 0;

        function selectDelivery(id, price) {
            shippingCost = price;
            document.getElementById('shipping-cost').textContent = price > 0 ? '$' + price.toFixed(2) : 'FREE';
            // Update radio visuals
            document.querySelectorAll('[id^="delivery-label-"]').forEach(el => {
                el.classList.remove('border-green-500', 'bg-green-50');
                el.classList.add('border-gray-200');
            });
            document.querySelectorAll('[id^="delivery-radio-"]').forEach(el => el.innerHTML = '');
            document.getElementById('delivery-label-' + id).classList.add('border-green-500', 'bg-green-50');
            document.getElementById('delivery-label-' + id).classList.remove('border-gray-200');
            document.getElementById('delivery-radio-' + id).innerHTML = '<div class="w-3 h-3 rounded-full bg-green-500"></div>';
            recalcTotal();
        }

        function recalcTotal() {
            const total = subtotal - discountAmount + shippingCost;
            document.getElementById('order-total').textContent = '$' + total.toFixed(2);
        }

        async function applyCoupon() {
            const code = document.getElementById('coupon-input').value.trim();
            if (!code) return;
            const msgEl = document.getElementById('coupon-msg');
            const res = await fetch('{{ route("checkout.applyCoupon") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ code })
            });
            const data = await res.json();
            msgEl.classList.remove('hidden', 'text-green-600', 'text-red-500');
            if (data.success) {
                msgEl.textContent = data.message;
                msgEl.classList.add('text-green-600');
                document.getElementById('coupon-id-input').value = data.coupon.id;
                if (data.coupon.type === 'percentage') {
                    discountAmount = Math.round(subtotal * (data.coupon.value / 100) * 100) / 100;
                } else {
                    discountAmount = Math.min(data.coupon.value, subtotal);
                }
                document.getElementById('discount-row').style.display = 'flex';
                document.getElementById('discount-amount').textContent = '-$' + discountAmount.toFixed(2);
                recalcTotal();
            } else {
                msgEl.textContent = data.message;
                msgEl.classList.add('text-red-500');
            }
        }
    </script>
</x-app-layout>
