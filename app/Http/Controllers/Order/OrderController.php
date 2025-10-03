<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display order history for authenticated user
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $orders = $user
            ->orders()
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Show single order details
     */
    public function show(Order $order)
    {
        // Authorization: ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('items.product');
        
        return view('orders.show', compact('order'));
    }

    /**
     * Show order confirmation page after successful checkout
     */
    public function confirmation(Order $order)
    {
        // Authorization: ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('items.product');
        
        return view('orders.confirmation', compact('order'));
    }
}
