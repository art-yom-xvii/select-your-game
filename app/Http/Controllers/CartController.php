<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index(Request $request): View
    {
        $cart = $this->getOrCreateCart($request);

        return view('cart.index', [
            'cart' => $cart,
            'items' => $cart->items()->with('product.primaryImage')->get(),
        ]);
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = $this->getOrCreateCart($request);
        $product = Product::query()->findOrFail($request->product_id);

        // Check if item already exists in cart
        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $request->quantity;
            $existingItem->update([
                'quantity' => min($newQuantity, 10), // Max 10 per item
            ]);
        } else {
            // Create new cart item
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        // Update cart total
        $cart->calculateTotal();

        if ($request->wantsJson() || $request->ajax()) {
            $cartCount = $cart->items()->sum('quantity');
            return response()->json(['success' => true, 'message' => $product->name . ' added to your cart!', 'cart_count' => $cartCount]);
        }

        return redirect()->route('cart.index')
            ->with('success', $product->name . ' added to your cart!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $item): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = $this->getOrCreateCart($request);

        // Ensure the item belongs to this cart
        if ($item->cart_id !== $cart->id) {
            return redirect()->route('cart.index')
                ->with('error', 'Invalid cart item.');
        }

        $item->update([
            'quantity' => $request->quantity,
        ]);

        // Update cart total
        $cart->calculateTotal();

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated!');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(Request $request, CartItem $item): RedirectResponse
    {
        $cart = $this->getOrCreateCart($request);

        // Ensure the item belongs to this cart
        if ($item->cart_id !== $cart->id) {
            return redirect()->route('cart.index')
                ->with('error', 'Invalid cart item.');
        }

        $item->delete();

        // Update cart total
        $cart->calculateTotal();

        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart.');
    }

    /**
     * Get the current cart or create a new one.
     */
    protected function getOrCreateCart(Request $request): Cart
    {
        $sessionId = $request->session()->get('cart_session_id');

        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->put('cart_session_id', $sessionId);
        }

        // Get cart by session ID or create a new one
        $cart = Cart::query()->firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id' => Auth::id(),
                'total' => 0,
            ]
        );

        // If user is logged in, associate cart with user
        if (Auth::check() && !$cart->user_id) {
            $cart->update(['user_id' => Auth::id()]);
        }

        return $cart;
    }
}
