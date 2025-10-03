@extends('admin.layout')

@section('admin-page', 'Order #'.$order->id)
@section('admin-content')
<div style="margin-bottom:1rem;">
    <a href="{{ route('admin.orders.index') }}" class="admin-text admin-muted">← Back to Orders</a>
</div>
<div class="admin-grid-2">
    <div class="admin-panel">
        <h3 class="admin-heading" style="margin-bottom:1rem;">Customer</h3>
        <div style="display:grid;gap:.6rem;">
            <div><span class="admin-muted">Name:</span> <strong>{{ $order->user->name }}</strong></div>
            <div><span class="admin-muted">Email:</span> <strong>{{ $order->user->email }}</strong></div>
            <div><span class="admin-muted">Customer Since:</span> <strong>{{ $order->user->created_at->format('M j, Y') }}</strong></div>
            <div style="margin-top:.5rem;">
                <a href="{{ route('admin.customers.show',$order->user) }}" class="px-btn btn-secondary admin-btn-sm">View Customer</a>
            </div>
        </div>
    </div>
    <div class="admin-panel">
        <h3 class="admin-heading" style="margin-bottom:1rem;">Order Status</h3>
        <form method="POST" action="{{ route('admin.orders.updateStatus',$order) }}">
            @csrf
            @method('PUT')
            <select name="status" class="admin-select" style="margin-bottom:.75rem;">
                @foreach(['pending','paid','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="px-btn btn-primary admin-btn" style="width:100%;">Update Status</button>
        </form>
        <div style="margin-top:1rem;display:grid;gap:.5rem;">
            <div><span class="admin-muted">Order ID:</span> <strong>#{{ $order->id }}</strong></div>
            <div><span class="admin-muted">Placed:</span> <strong>{{ $order->created_at->format('F j, Y g:i A') }}</strong></div>
            <div><span class="admin-muted">Status:</span> <span class="admin-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></div>
            @if($order->meta && is_array($order->meta))
                <div style="border-top:1px solid var(--px-border);padding-top:.5rem;">
                    <span class="admin-muted">Payment:</span> <strong>{{ $order->meta['payment'] ?? 'N/A' }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="admin-panel" style="margin-top:1.25rem;">
    <h3 class="admin-heading" style="margin-bottom:1rem;">Items</h3>
    @foreach($order->items as $item)
        <div style="display:flex;gap:1rem;padding:.9rem;border:1px solid var(--px-border);border-radius:6px;margin-bottom:.75rem;">
            @if($item->product && $item->product->image_url)
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->pokemon_name }}" style="width:74px;height:74px;object-fit:contain;border:1px solid var(--px-border);border-radius:4px;background:#fff;" />
            @else
                <div style="width:74px;height:74px;border:1px solid var(--px-border);border-radius:4px;display:flex;align-items:center;justify-content:center;" class="admin-muted text-xs">No Image</div>
            @endif
            <div style="flex:1;">
                <div class="admin-text" style="font-weight:600;">{{ $item->product->pokemon_name ?? $item->product->card_name ?? 'Product Unavailable' }}</div>
                <div class="admin-muted" style="font-size:.75rem;margin-top:.25rem;">Qty: {{ $item->quantity }} • Unit: ${{ number_format($item->unit_price,2) }}</div>
            </div>
            <div style="text-align:right;font-weight:700;">${{ number_format($item->unit_price * $item->quantity,2) }}</div>
        </div>
    @endforeach
    <div style="border-top:1px solid var(--px-border);padding-top:.75rem;margin-top:.5rem;display:grid;gap:.4rem;">
        <div style="display:flex;justify-content:space-between;" class="admin-muted"><span>Subtotal:</span><span>${{ number_format($order->total,2) }}</span></div>
        <div style="display:flex;justify-content:space-between;" class="admin-muted"><span>Shipping:</span><span class="px-text-success">FREE</span></div>
        <div style="display:flex;justify-content:space-between;font-weight:600;padding-top:.4rem;border-top:1px solid var(--px-border);"><span>Total Paid:</span><span class="px-text-primary">${{ number_format($order->total,2) }}</span></div>
    </div>
</div>
@endsection
