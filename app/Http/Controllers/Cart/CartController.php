<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    /**
     * Show cart page (HTML)
     */
    public function index()
    {
        $cart = $this->getUserCart();
        $cart->load('items.product');
        return view('cart.index', compact('cart'));
    }

    /**
     * Return cart items as JSON (for Livewire/fetch)
     */
    public function itemsJson()
    {
        $cart = $this->getUserCart();
        $cart->load('items.product');
        return response()->json([
            'items' => $cart->items->map(fn ($i) => [
                'id'        => $i->id,
                'product_id'=> $i->product_id,
                'name'      => $i->product->name ?? '',
                'qty'       => $i->quantity,
                'unit_price'=> (float)$i->price,
                'line_total'=> (float)$i->price * $i->quantity,
            ]),
            'total' => $cart->items->sum(fn ($i) => $i->price * $i->quantity),
        ]);
    }

    /**
     * Add product (increments quantity)
     */
    public function add(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId);
        if ($product->stock <= 0) {
            return back()->withErrors('Out of stock');
        }

        $cart = $this->getUserCart();

        $item = $cart->items()->firstOrCreate(
            ['product_id' => $product->id],
            ['price' => $product->price, 'quantity' => 0]
        );

        $item->quantity += 1;
        $item->save();

        return back()->with('success', 'Added to cart');
    }

    /**
     * Update quantity for a product
     */
    public function updateQuantity(Request $request, int $productId)
    {
        $qty = max(0, (int)$request->input('quantity', 1));
        $cart = $this->getExistingCart();
        if (!$cart) return back();

        $item = $cart->items()->where('product_id', $productId)->first();
        if (!$item) return back();

        if ($qty === 0) {
            $item->delete();
        } else {
            // Optional stock check
            if ($item->product && $item->product->stock < $qty) {
                return back()->withErrors('Insufficient stock');
            }
            $item->quantity = $qty;
            $item->save();
        }
        return back();
    }

    /**
     * Remove one product line
     */
    public function remove(Request $request, int $productId)
    {
        $cart = $this->getExistingCart();
        if ($cart) {
            $cart->items()->where('product_id', $productId)->delete();
        }
        return back()->with('success', 'Item removed');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $cart = $this->getExistingCart();
        if ($cart) {
            $cart->items()->delete();
        }
        return back()->with('success', 'Cart cleared');
    }

    /**
     * Checkout: create order + order_items, decrement stock, clear cart
     */
    public function checkout(Request $request)
    {
        $cart = $this->getExistingCart();
        if (!$cart || $cart->items->isEmpty()) {
            return back()->withErrors('Cart is empty');
        }

        $cart->load('items.product');

        // Recompute totals & validate stock
        $total = 0;
        foreach ($cart->items as $item) {
            if (!$item->product || $item->product->stock < $item->quantity) {
                return back()->withErrors('Stock changed for a product');
            }
            // Use stored line price (price snapshot) if set; fallback to current product price
            $unit = $item->price ?: $item->product->price;
            $total += $unit * $item->quantity;
        }

        $orderId = null;
        
        DB::transaction(function () use ($cart, $total, &$orderId) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total'   => $total,
                'status'  => 'paid',
                'meta'    => ['payment' => 'dummy']
            ]);

            $orderId = $order->id;

            foreach ($cart->items as $item) {
                $unit = $item->price ?: ($item->product->price ?? 0);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $unit,
                ]);
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Clear items
            $cart->items()->delete();
        });

        return redirect()->route('orders.confirmation', $orderId)->with('success', 'Order placed successfully!');
    }

    /* ===== Helper methods ===== */

    protected function getUserCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    protected function getExistingCart(): ?Cart
    {
        return Cart::where('user_id', Auth::id())->first();
    }
}