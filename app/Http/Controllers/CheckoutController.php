<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $cartItems = $cart->items()->with('product.seller')->get();
        
        // Group items by seller
        $itemsBySeller = $cartItems->groupBy('product.seller_id');
        
        return view('checkout.index', compact('cartItems', 'itemsBySeller'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_phone' => 'required|string',
        ]);

        $cart = auth()->user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        try {
            DB::beginTransaction();

            // Group items by seller to create separate orders
            $itemsBySeller = $cart->items()->with('product.seller')->get()->groupBy('product.seller_id');

            $orders = [];

            foreach ($itemsBySeller as $sellerId => $items) {
                $subtotal = $items->sum(function ($item) {
                    return $item->quantity * $item->price;
                });

                $shipping = 10.00; // Flat shipping rate
                $tax = $subtotal * 0.06; // 6% tax
                $total = $subtotal + $shipping + $tax;

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'seller_id' => $sellerId,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => $total,
                    'shipping_address' => $request->shipping_address,
                    'shipping_phone' => $request->shipping_phone,
                    'notes' => $request->notes,
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'total' => $item->quantity * $item->price,
                    ]);

                    // Reduce stock
                    $item->product->decrement('stock', $item->quantity);
                }

                $orders[] = $order;
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            // Redirect to payment for the first order (in multi-vendor, handle multiple payments)
            return redirect()->route('payment.index', ['order' => $orders[0]->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order creation failed: ' . $e->getMessage());
        }
    }
}
