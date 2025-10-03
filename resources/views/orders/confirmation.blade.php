@extends('layouts.app')

@section('content')
<div class="px-container">
    <div class="px-panel" style="max-width: 800px; margin: 3rem auto;">
        <!-- Success Header -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">✓</div>
            <h1 class="px-heading-xl" style="margin-bottom: 0.5rem;">Order Confirmed!</h1>
            <p class="px-text-muted">Thank you for your purchase</p>
        </div>

        <!-- Order Details -->
        <div class="px-section">
            <h2 class="px-heading-lg">Order #{{ $order->id }}</h2>
            <p class="px-text-muted">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <!-- Order Items -->
        <div class="px-section">
            <h3 class="px-heading-md" style="margin-bottom: 1rem;">Items Ordered</h3>
            
            @foreach($order->items as $item)
            <div class="px-card-horizontal" style="margin-bottom: 1rem;">
                @if($item->product && $item->product->image_url)
                    @php $img = $item->product->image_url; @endphp
                    <img 
                        src="{{ $img }}" 
                        alt="{{ $item->product->pokemon_name ?? $item->product->card_name ?? 'Product' }}"
                        class="px-cart-image"
                    >
                @else
                    <div class="px-cart-image" style="background: var(--px-surface-dark); display: flex; align-items: center; justify-content: center;">
                        <span style="color: var(--px-text-muted);">No Image</span>
                    </div>
                @endif

                <div style="flex: 1; padding: 1rem;">
                    <h4 class="px-heading-sm">{{ $item->product->pokemon_name ?? $item->product->card_name ?? 'Product Unavailable' }}</h4>
                    <p class="px-text-muted">Quantity: {{ $item->quantity }}</p>
                    <p class="px-text-muted">Unit Price: ${{ number_format($item->unit_price, 2) }}</p>
                </div>

                <div style="padding: 1rem; text-align: right;">
                    <p class="px-text-primary" style="font-size: 1.25rem; font-weight: bold;">
                        ${{ number_format($item->unit_price * $item->quantity, 2) }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="px-cart-summary">
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span class="px-text-muted">Subtotal:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span class="px-text-muted">Shipping:</span>
                <span>FREE</span>
            </div>
            <div style="border-top: 2px solid var(--px-primary); padding-top: 1rem; display: flex; justify-content: space-between;">
                <span class="px-heading-md">Total:</span>
                <span class="px-heading-md px-text-primary">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <!-- Status -->
        <div class="px-section">
            <div style="background: var(--px-success-bg); border: 2px solid var(--px-success); padding: 1rem; border-radius: 8px;">
                <p style="margin: 0;">
                    <strong>Status:</strong> 
                    <span class="px-badge" style="background: var(--px-success); color: white; padding: 0.25rem 0.75rem; border-radius: 4px; margin-left: 0.5rem;">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
            <a href="{{ route('home') }}" class="px-btn px-btn-secondary">
                Continue Shopping
            </a>
            <a href="{{ route('orders.index') }}" class="px-btn px-btn-primary">
                View All Orders
            </a>
        </div>
    </div>
</div>
@endsection
