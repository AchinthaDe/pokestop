@extends('layouts.app')

@section('content')
<div class="px-container">
    <div class="px-panel" style="max-width: 1200px; margin: 3rem auto;">
        <h1 class="px-heading-xl" style="margin-bottom: 2rem;">Order History</h1>

        @if($orders->isEmpty())
            <div class="px-cart-empty">
                <p style="font-size: 4rem; margin-bottom: 1rem;">📦</p>
                <p class="px-heading-lg" style="margin-bottom: 0.5rem;">No Orders Yet</p>
                <p class="px-text-muted" style="margin-bottom: 2rem;">You haven't placed any orders yet.</p>
                <a href="{{ route('products.browse') }}" class="px-btn px-btn-primary">
                    Start Shopping
                </a>
            </div>
        @else
            <!-- Orders Table -->
            <div style="overflow-x: auto;">
                <table class="px-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--px-surface-dark); border-bottom: 2px solid var(--px-primary);">
                            <th style="padding: 1rem; text-align: left;">Order #</th>
                            <th style="padding: 1rem; text-align: left;">Date</th>
                            <th style="padding: 1rem; text-align: left;">Items</th>
                            <th style="padding: 1rem; text-align: left;">Total</th>
                            <th style="padding: 1rem; text-align: left;">Status</th>
                            <th style="padding: 1rem; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr style="border-bottom: 1px solid var(--px-border);">
                            <td style="padding: 1rem;">
                                <strong>#{{ $order->id }}</strong>
                            </td>
                            <td style="padding: 1rem;">
                                {{ $order->created_at->format('M j, Y') }}
                            </td>
                            <td style="padding: 1rem;">
                                {{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}
                            </td>
                            <td style="padding: 1rem;">
                                <strong class="px-text-primary">${{ number_format($order->total, 2) }}</strong>
                            </td>
                            <td style="padding: 1rem;">
                                <span class="px-badge" style="
                                    background: {{ $order->status === 'paid' ? 'var(--px-success)' : 'var(--px-warning)' }}; 
                                    color: white; 
                                    padding: 0.25rem 0.75rem; 
                                    border-radius: 4px;
                                    display: inline-block;
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <a href="{{ route('orders.show', $order) }}" class="px-btn px-btn-sm px-btn-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem;">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
