@extends('admin.layout')

@section('admin-page', 'Customers')
@section('admin-subtitle', 'Manage customer accounts and permissions')
@section('admin-content')
<div class="admin-panel" style="margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('admin.customers.index') }}" class="admin-action-bar">
        <div style="flex:1;min-width:260px;">
            <label for="search" class="admin-text admin-muted" style="display:block;margin-bottom:.4rem;font-size:.7rem;text-transform:uppercase;letter-spacing:1px;">Search Customers</label>
            <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Customer name or email" class="admin-input">
        </div>
        <div style="min-width:180px;">
            <label for="banned" class="admin-text admin-muted" style="display:block;margin-bottom:.4rem;font-size:.7rem;text-transform:uppercase;letter-spacing:1px;">Account Status</label>
            <select id="banned" name="banned" class="admin-select">
                <option value="">All Customers</option>
                <option value="no" {{ request('banned')==='no' ? 'selected' : '' }}>Active Only</option>
                <option value="yes" {{ request('banned')==='yes' ? 'selected' : '' }}>Banned Only</option>
            </select>
        </div>
        <div style="display:flex;align-items:flex-end;gap:.65rem;">
            <button class="px-btn btn-primary admin-btn">Apply Filters</button>
            @if(request('search') || request('banned'))
                <a href="{{ route('admin.customers.index') }}" class="px-btn btn-secondary admin-btn">Clear</a>
            @endif
        </div>
    </form>
</div>
<div class="admin-panel">
    <div style="margin-bottom:1.25rem;display:flex;justify-content:space-between;align-items:center;">
        <span class="admin-muted" style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;">Showing {{ $customers->total() }} Customers</span>
    </div>
    @if($customers->isEmpty())
        <p class="admin-text admin-muted" style="text-align:center;padding:2rem;">No customers found.</p>
    @else
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Orders</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr class="{{ $customer->banned ? 'bg-red-950/40' : '' }}">
                            <td>
                                <strong>{{ $customer->name }}</strong>
                                @if($customer->banned)
                                    <div class="admin-muted" style="font-size:.6rem;">BANNED</div>
                                @endif
                            </td>
                            <td class="admin-muted">{{ $customer->email }}</td>
                            <td>{{ $customer->orders_count }}</td>
                            <td>{{ $customer->created_at->format('M j, Y') }}</td>
                            <td>
                                @if($customer->banned)
                                    <span class="admin-badge danger">Banned</span>
                                @else
                                    <span class="admin-badge success">Active</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <a href="{{ route('admin.customers.show',$customer) }}" class="px-btn btn-primary admin-btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
