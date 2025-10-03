@extends('admin.layout')

@section('admin-page', 'Customer: '.$user->name)
@section('admin-content')
<div style="margin-bottom:1rem;">
    <a href="{{ route('admin.customers.index') }}" class="admin-text admin-muted">← Back to Customers</a>
</div>
<div class="admin-grid-2" style="margin-bottom:1.25rem;">
    <div class="admin-panel">
        <h3 class="admin-heading" style="margin-bottom:.75rem;">Customer</h3>
        <div style="display:grid;gap:.6rem;">
            <div><span class="admin-muted">Name:</span> <strong>{{ $user->name }}</strong></div>
            <div><span class="admin-muted">Email:</span> <strong>{{ $user->email }}</strong></div>
            <div><span class="admin-muted">Member Since:</span> <strong>{{ $user->created_at->format('F j, Y') }}</strong></div>
            <div><span class="admin-muted">Status:</span> <span class="admin-badge {{ $user->banned ? 'danger' : 'success' }}">{{ $user->banned ? 'Banned' : 'Active' }}</span></div>
            @if($user->banned && $user->ban_reason)
                <div class="admin-panel" style="background:rgba(255,0,0,0.05);border-color:var(--px-danger);">
                    <div class="admin-muted" style="font-size:.6rem;">Ban Reason</div>
                    <div class="admin-text" style="font-weight:600;">{{ $user->ban_reason }}</div>
                    <div class="admin-muted" style="font-size:.6rem;">Banned on {{ $user->banned_at->format('F j, Y g:i A') }}</div>
                </div>
            @endif
        </div>
    </div>
    <div class="admin-panel">
        <h3 class="admin-heading" style="margin-bottom:.75rem;">Purchase Stats</h3>
        <div style="display:grid;gap:.8rem;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));">
            <div class="admin-panel" style="padding:.6rem;">
                <div class="admin-muted" style="font-size:.55rem;">Orders</div>
                <div class="admin-heading" style="color:var(--px-accent);">{{ $stats['total_orders'] }}</div>
            </div>
            <div class="admin-panel" style="padding:.6rem;">
                <div class="admin-muted" style="font-size:.55rem;">Total Spent</div>
                <div class="admin-heading" style="color:var(--px-green);">${{ number_format($stats['total_spent'],2) }}</div>
            </div>
            <div class="admin-panel" style="padding:.6rem;">
                <div class="admin-muted" style="font-size:.55rem;">Avg Order</div>
                <div class="admin-heading" style="color:var(--px-yellow);">${{ number_format($stats['average_order'] ?? 0,2) }}</div>
            </div>
        </div>
    </div>
</div>
<div class="admin-panel" style="margin-bottom:1.25rem;">
    <h3 class="admin-heading" style="margin-bottom:.75rem;">Account Actions</h3>
    @if($user->banned)
        <form method="POST" action="{{ route('admin.customers.unban',$user) }}" onsubmit="return confirm('Unban this user?');">
            @csrf
            <button class="px-btn btn-primary admin-btn">Unban Customer</button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.customers.ban',$user) }}" onsubmit="return confirm('Ban this user?');">
            @csrf
            <label class="admin-text admin-muted" for="reason">Reason</label>
            <textarea id="reason" name="reason" required class="admin-textarea" style="min-height:90px;margin:.4rem 0  .6rem;"></textarea>
            <button class="px-btn btn-danger admin-btn">Ban Customer</button>
        </form>
    @endif
</div>
<div class="admin-panel">
    <h3 class="admin-heading" style="margin-bottom:.75rem;">Order History</h3>
    @if($user->orders->isEmpty())
        <p class="admin-text admin-muted" style="text-align:center;padding:2rem;">No orders.</p>
    @else
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('M j, Y') }}</td>
                            <td>{{ $order->items->count() }}</td>
                            <td><strong class="px-text-primary">${{ number_format($order->total,2) }}</strong></td>
                            <td><span class="admin-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td style="text-align:center;">
                                <a href="{{ route('admin.orders.show',$order) }}" class="px-btn btn-primary admin-btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
