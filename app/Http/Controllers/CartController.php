<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product.seller')->get();
        $total = $cart->getTotal();

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock');
        }

        $cart = $this->getOrCreateCart();

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Item removed from cart');
    }

    private function getOrCreateCart()
    {
        $cart = auth()->user()->cart;

        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }

        return $cart;
    }
}
