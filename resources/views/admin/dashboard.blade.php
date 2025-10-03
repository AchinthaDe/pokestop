@extends('admin.layout')

@section('admin-page','Dashboard')
@section('admin-content')
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;margin-bottom:2rem;">
    <div class="admin-panel" style="text-align:center;padding:1.5rem 1rem;">
        <div class="admin-muted" style="font-size:.65rem;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:.75rem;">Total Orders</div>
        <div style="font-size:2.5rem;color:var(--px-accent);font-weight:700;font-family:var(--px-mono);">{{ $stats['total_orders'] }}</div>
    </div>
    <div class="admin-panel" style="text-align:center;padding:1.5rem 1rem;">
        <div class="admin-muted" style="font-size:.65rem;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:.75rem;">Revenue</div>
        <div style="font-size:2.5rem;color:var(--px-green);font-weight:700;font-family:var(--px-mono);">${{ number_format($stats['total_revenue'],2) }}</div>
    </div>
    <div class="admin-panel" style="text-align:center;padding:1.5rem 1rem;">
        <div class="admin-muted" style="font-size:.65rem;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:.75rem;">Products</div>
        <div style="font-size:2.5rem;color:var(--px-yellow);font-weight:700;font-family:var(--px-mono);">{{ $stats['total_products'] }}</div>
    </div>
    <div class="admin-panel" style="text-align:center;padding:1.5rem 1rem;">
        <div class="admin-muted" style="font-size:.65rem;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:.75rem;">Customers</div>
        <div style="font-size:2.5rem;color:var(--px-secondary);font-weight:700;font-family:var(--px-mono);">{{ $stats['total_users'] }}</div>
    </div>
</div>
<div style="grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div class="admin-panel">
        <h3 class="admin-heading" style="margin:0 0 1.25rem 0;">Recent Orders</h3>
        @if($stats['recent_orders']->isEmpty())
            <p class="admin-text admin-muted">No orders yet.</p>
        @else
            <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_orders'] as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->items->count() }}</td>
                                <td><strong>${{ number_format($order->total,2) }}</strong></td>
                                <td><span class="admin-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td style="text-align:center;"><a href="{{ route('admin.orders.show',$order) }}" class="px-btn btn-primary admin-btn-sm">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1rem;text-align:center;">
                <a href="{{ route('admin.orders.index') }}" class="px-link" style="font-size:.75rem;">View All Orders →</a>
            </div>
        @endif
    </div>
    <div class="admin-panel">
        <h3 class="admin-heading" style="margin:0 0 1.25rem 0;">Low Stock Products</h3>
        @if($stats['low_stock_products']->isEmpty())
            <p class="admin-text admin-muted">All products have sufficient stock.</p>
        @else
            <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['low_stock_products'] as $product)
                            <tr>
                                <td>{{ $product->pokemon_name ?? $product->card_name }}</td>
                                <td>
                                    <span style="color:{{ $product->stock <=2 ? 'var(--px-danger)' : 'var(--px-yellow)' }};font-weight:700;">{{ $product->stock }}</span>
                                </td>
                                <td>${{ number_format($product->price,2) }}</td>
                                <td style="text-align:center;"><a href="{{ route('admin.products.edit',$product) }}" class="px-btn btn-primary admin-btn-sm">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
