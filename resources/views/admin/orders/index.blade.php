@extends('admin.layout')

@section('admin-page', 'Orders')
@section('admin-subtitle', 'View and manage all customer orders')
@section('admin-content')
<div class="admin-panel" style="margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="admin-action-bar">
        <div style="flex:1;min-width:260px;">
            <label class="admin-text admin-muted" for="search" style="display:block;margin-bottom:.4rem;font-size:.7rem;text-transform:uppercase;letter-spacing:1px;">Search Orders</label>
            <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Order # or customer name" class="admin-input">
        </div>
        <div style="min-width:180px;">
            <label class="admin-text admin-muted" for="status" style="display:block;margin-bottom:.4rem;font-size:.7rem;text-transform:uppercase;letter-spacing:1px;">Filter by Status</label>
            <select id="status" name="status" class="admin-select">
                <option value="">All Statuses</option>
                @foreach(['pending','paid','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex;align-items:flex-end;gap:.65rem;">
            <button class="px-btn btn-primary admin-btn">Apply Filters</button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.orders.index') }}" class="px-btn btn-secondary admin-btn">Clear</a>
            @endif
        </div>
    </form>
</div>

<div class="admin-panel">
    <div style="margin-bottom:1.25rem;display:flex;justify-content:space-between;align-items:center;">
        <span class="admin-muted" style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;">Showing {{ $orders->total() }} Orders</span>
    </div>
    @if($orders->isEmpty())
        <p class="admin-text admin-muted" style="text-align:center;padding:2rem;">No orders found.</p>
    @else
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->user->name }}</td>
                            <td class="admin-muted">{{ $order->user->email }}</td>
                            <td>{{ $order->items->count() }}</td>
                            <td><strong class="px-text-primary">${{ number_format($order->total,2) }}</strong></td>
                            <td>
                                <span class="admin-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>{{ $order->created_at->format('M j, Y g:i A') }}</td>
                            <td style="text-align:center;">
                                <a href="{{ route('admin.orders.show',$order) }}" class="px-btn btn-primary admin-btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
