<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use App\Models\Coupon;
use App\Models\DeliveryOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = $cart->items()->with('shoe')->get();
        $subtotal = $items->sum(fn($i) => $i->price_snapshot * $i->quantity);
        $deliveryOptions = DeliveryOption::where('is_active', true)->get();

        return view('checkout.show', compact('items', 'subtotal', 'deliveryOptions'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json(['success' => false, 'message' => 'This coupon has reached its usage limit.']);
        }

        return response()->json([
            'success' => true,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'type' => $coupon->discount_type,
                'value' => $coupon->discount_value,
            ],
            'message' => 'Coupon applied!'
        ]);
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_zip' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'shipping_phone' => 'nullable|string|max:20',
            'delivery_option_id' => 'required|exists:delivery_options,id',
            'coupon_id' => 'nullable|exists:coupons,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart || $cart->items()->count() === 0) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        $items = $cart->items()->with('shoe')->get();
        $subtotal = $items->sum(fn($i) => $i->price_snapshot * $i->quantity);
        $deliveryOption = DeliveryOption::findOrFail($request->delivery_option_id);
        $deliveryFee = $deliveryOption->price;
        $discount = 0;

        // Apply coupon
        if ($request->coupon_id) {
            $coupon = Coupon::find($request->coupon_id);
            if ($coupon && $coupon->is_active) {
                if ($coupon->discount_type === 'percentage') {
                    $discount = round($subtotal * ($coupon->discount_value / 100), 2);
                } else {
                    $discount = min($coupon->discount_value, $subtotal);
                }
                $coupon->increment('used_count');
            }
        }

        $total = $subtotal - $discount + $deliveryFee;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => Auth::id(),
                'coupon_id' => $request->coupon_id,
                'delivery_option_id' => $request->delivery_option_id,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zip' => $request->shipping_zip,
                'shipping_country' => $request->shipping_country,
                'shipping_phone' => $request->shipping_phone,
                'notes' => $request->notes,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'shoe_id' => $item->shoe_id,
                    'shoe_design_id' => $item->shoe_design_id,
                    'design_snapshot' => $item->design_snapshot,
                    'size' => $item->size,
                    'quantity' => $item->quantity,
                    'price_snapshot' => $item->price_snapshot,
                ]);
            }

            OrderTracking::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'note' => 'Order placed successfully.',
            ]);

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('checkout.confirmation', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement failed: ' . $e->getMessage());
            return back()->withErrors(['order' => 'Something went wrong. Please try again.']);
        }
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.shoe');

        return view('checkout.confirmation', compact('order'));
    }
}
