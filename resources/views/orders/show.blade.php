@extends('layouts.app')

@section('content')
<div class="px-container">
    <div class="px-panel" style="max-width: 900px; margin: 3rem auto;">
        <!-- Back Button -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('orders.index') }}" class="px-link" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                ← Back to Orders
            </a>
        </div>

        <!-- Order Header -->
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 class="px-heading-xl">Order #{{ $order->id }}</h1>
                <p class="px-text-muted">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <div>
                <span class="px-badge" style="
                    background: {{ $order->status === 'paid' ? 'var(--px-success)' : 'var(--px-warning)' }}; 
                    color: white; 
                    padding: 0.5rem 1rem; 
                    border-radius: 4px;
                    font-size: 1rem;
                ">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="px-section">
            <h2 class="px-heading-lg" style="margin-bottom: 1.5rem;">Order Items</h2>
            
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
                    <h3 class="px-heading-sm" style="margin-bottom: 0.5rem;">
                        {{ $item->product->pokemon_name ?? $item->product->card_name ?? 'Product Unavailable' }}
                    </h3>
                    @if($item->product && $item->product->set_name)
                        <p class="px-text-muted" style="font-size: 0.875rem; margin-bottom: 0.5rem;">
                            {{ $item->product->set_name }}
                        </p>
                    @endif
                    <div style="display: flex; gap: 1.5rem; font-size: 0.875rem;">
                        <span class="px-text-muted">Qty: <strong>{{ $item->quantity }}</strong></span>
                        <span class="px-text-muted">Unit Price: <strong>${{ number_format($item->unit_price, 2) }}</strong></span>
                    </div>
                </div>

                <div style="padding: 1rem; text-align: right;">
                    <p class="px-text-primary" style="font-size: 1.5rem; font-weight: bold;">
                        ${{ number_format($item->unit_price * $item->quantity, 2) }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="px-cart-summary">
            <h3 class="px-heading-md" style="margin-bottom: 1rem;">Order Summary</h3>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                <span class="px-text-muted">Subtotal ({{ $order->items->sum('quantity') }} items):</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                <span class="px-text-muted">Shipping:</span>
                <span class="px-text-success">FREE</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                <span class="px-text-muted">Tax:</span>
                <span>$0.00</span>
            </div>
            
            <div style="border-top: 2px solid var(--px-primary); padding-top: 1rem; margin-top: 1rem; display: flex; justify-content: space-between;">
                <span class="px-heading-lg">Total Paid:</span>
                <span class="px-heading-lg px-text-primary">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <!-- Additional Information -->
        @if($order->meta && is_array($order->meta))
        <div class="px-section">
            <h3 class="px-heading-md" style="margin-bottom: 1rem;">Payment Information</h3>
            <div style="background: var(--px-surface-dark); padding: 1rem; border-radius: 8px;">
                @foreach($order->meta as $key => $value)
                    <p style="margin: 0.5rem 0;">
                        <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                    </p>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; flex-wrap: wrap;">
            <a href="{{ route('products.browse') }}" class="px-btn px-btn-secondary">
                Continue Shopping
            </a>
            <a href="{{ route('orders.index') }}" class="px-btn px-btn-primary">
                View All Orders
            </a>
        </div>
    </div>
</div>
@endsection
