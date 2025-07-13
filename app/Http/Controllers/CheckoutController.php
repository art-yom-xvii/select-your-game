<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function index(Request $request): View|RedirectResponse
    {
        // Get the current cart
        $sessionId = $request->session()->get('cart_session_id');

        if (!$sessionId) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $cart = Cart::query()
            ->where('session_id', $sessionId)
            ->with(['items.product.primaryImage'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', [
            'cart' => $cart,
        ]);
    }

    /**
     * Process the checkout.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'billing_address' => 'required|string',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        // Get the current cart
        $sessionId = $request->session()->get('cart_session_id');

        if (!$sessionId) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $cart = Cart::query()
            ->where('session_id', $sessionId)
            ->with(['items.product'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Create the order
        $order = new Order();
        $order->user_id = Auth::id();
        $order->order_number = Order::generateOrderNumber();
        $order->status = 'pending';
        $order->customer_email = $request->customer_email;
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->billing_address = $request->billing_address;
        $order->shipping_address = $request->shipping_address;
        $order->payment_method = $request->payment_method;
        $order->subtotal = $cart->total;

        // Calculate tax (e.g., 8%)
        $order->tax = round($cart->total * 0.08, 2);

        // Add shipping cost (flat rate of $5.99)
        $order->shipping_cost = 5.99;

        // Calculate total
        $order->total = $order->subtotal + $order->tax + $order->shipping_cost;

        $order->save();

        // Create order items
        foreach ($cart->items as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->product_name = $cartItem->product->name;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->price;
            $orderItem->subtotal = $cartItem->price * $cartItem->quantity;
            $orderItem->sku = $cartItem->product->sku;
            $orderItem->save();
        }

        // Clear the cart
        $cart->items()->delete();
        $cart->delete();
        $request->session()->forget('cart_session_id');

        // Redirect to thank you page
        return redirect()->route('checkout.confirmation', ['order' => $order->id])
            ->with('success', 'Your order has been placed!');
    }

    /**
     * Show the order confirmation page.
     */
    public function confirmation(Order $order): View
    {
        // Make sure the order belongs to the current user if logged in
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        // Load order items
        $order->load('items');

        return view('checkout.confirmation', [
            'order' => $order,
        ]);
    }
}
