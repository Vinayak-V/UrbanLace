<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get or create a cart for the current user/session.
     */
    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    /**
     * Display the cart page.
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('shoe')->get();
        $subtotal = $items->sum(fn($item) => $item->price_snapshot * $item->quantity);

        return view('cart.index', compact('cart', 'items', 'subtotal'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'shoe_id' => 'required|exists:shoes,id',
            'shoe_design_id' => 'nullable|exists:shoe_designs,id',
            'design_snapshot' => 'required|json',
            'size' => 'required|numeric|min:4|max:15',
            'price_snapshot' => 'required|numeric|min:0',
        ]);

        $cart = $this->getOrCreateCart();

        $cart->items()->create([
            'shoe_id' => $request->shoe_id,
            'shoe_design_id' => $request->shoe_design_id,
            'design_snapshot' => json_decode($request->design_snapshot, true),
            'size' => $request->size,
            'quantity' => 1,
            'price_snapshot' => $request->price_snapshot,
        ]);

        return response()->json(['success' => true, 'message' => 'Added to cart!', 'cart_count' => $cart->items()->count()]);
    }

    /**
     * Update item quantity.
     */
    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $item->update(['quantity' => $request->quantity]);

        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('shoe')->get();
        $subtotal = $items->sum(fn($i) => $i->price_snapshot * $i->quantity);

        return response()->json(['success' => true, 'subtotal' => $subtotal]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(CartItem $item)
    {
        $item->delete();

        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('shoe')->get();
        $subtotal = $items->sum(fn($i) => $i->price_snapshot * $i->quantity);

        return response()->json(['success' => true, 'subtotal' => $subtotal, 'cart_count' => $cart->items()->count()]);
    }
}
