@extends('layouts.app')

@section('content')
<div class="admin-root" style="min-height:100vh;">
    <!-- Sidebar -->
    <aside class="admin-sidebar" style="padding:1.5rem 1.25rem;">
        <div style="margin-bottom:2rem;">
            <h1 class="admin-title" style="margin:0;font-weight:700;">Admin</h1>
            <div style="font-size:.65rem;color:var(--px-muted);margin-top:.25rem;letter-spacing:1px;">Control Panel</div>
        </div>
        <nav style="display:flex;flex-direction:column;gap:.55rem;margin-bottom:2rem;">
            <a href="{{ route('admin.dashboard') }}" class="px-btn {{ request()->routeIs('admin.dashboard') ? 'btn-primary' : 'btn-secondary' }}" style="width:100%;text-align:left;font-size:.75rem;letter-spacing:1px;padding:.6rem .8rem;">Dashboard</a>
            <a href="{{ route('admin.orders.index') }}" class="px-btn {{ request()->routeIs('admin.orders.*') ? 'btn-primary' : 'btn-secondary' }}" style="width:100%;text-align:left;font-size:.75rem;letter-spacing:1px;padding:.6rem .8rem;">Orders</a>
            <a href="{{ route('admin.products.index') }}" class="px-btn {{ request()->routeIs('admin.products.*') ? 'btn-primary' : 'btn-secondary' }}" style="width:100%;text-align:left;font-size:.75rem;letter-spacing:1px;padding:.6rem .8rem;">Products</a>
            <a href="{{ route('admin.customers.index') }}" class="px-btn {{ request()->routeIs('admin.customers.*') ? 'btn-primary' : 'btn-secondary' }}" style="width:100%;text-align:left;font-size:.75rem;letter-spacing:1px;padding:.6rem .8rem;">Customers</a>
        </nav>
        <div style="margin-top:auto;padding-top:1.25rem;border-top:1px solid var(--px-border);display:flex;flex-direction:column;gap:.75rem;">
            <a href="{{ route('home') }}" class="px-btn btn-dark" style="width:100%;text-align:left;font-size:.7rem;padding:.55rem .75rem;">← Back to Store</a>
            <div style="font-size:.55rem;letter-spacing:1px;color:var(--px-muted);text-transform:uppercase;line-height:1.3;">
                <div>Laravel Admin Panel</div>
                <div>Pixel Theme</div>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <main class="admin-main" style="padding:2rem 2.5rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:2px solid var(--px-border);">
            <div>
                <h2 class="admin-heading" style="margin:0;font-weight:600;">@yield('admin-page','Dashboard')</h2>
                @if(trim($__env->yieldContent('admin-subtitle')))
                    <div style="font-size:.65rem;color:var(--px-muted);margin-top:.4rem;letter-spacing:1px;">@yield('admin-subtitle')</div>
                @endif
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="px-btn btn-danger admin-btn-sm" style="font-size:.7rem;">Logout</button>
            </form>
        </div>
        @if (session('status'))
            <div class="px-alert alert-success" style="margin-bottom:1.25rem;font-size:.75rem;">{{ session('status') }}</div>
        @endif
        @yield('admin-content')
    </main>
</div>
@endsection
