<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PokéStop') }}</title>

    <!-- Pixel era font (fallback handled if not loaded) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @if(str_starts_with(Route::currentRouteName(),'admin.'))
            @vite(['resources/css/admin.css'])
        @endif
        <livewire:styles />
    </head>
    <body>
        <div class="px-water-overlay"></div>
        @if(!request()->is('admin*'))
        <header class="px-nav">
            <div class="px-nav-inner">
                <a href="{{ route('home') }}" class="px-logo">POKÉSTOP</a>
                <nav class="flex gap-2">
                    <a href="{{ route('home') }}" class="px-link {{ request()->routeIs('home') ? 'px-link-active' : '' }}">HOME</a>
                    <a href="{{ route('products.browse') }}" class="px-link {{ request()->routeIs('products.browse') ? 'px-link-active' : '' }}">BROWSE</a>
                    @auth
                        @php
                            $cartCount = auth()->user()->cart ? auth()->user()->cart->items()->sum('quantity') : 0;
                        @endphp
                        <span class="px-cart-badge">
                            <a href="{{ route('cart.index') }}" class="px-link {{ request()->routeIs('cart.index') ? 'px-link-active' : '' }}">CART</a>
                            @if($cartCount > 0)
                                <span class="px-cart-count">{{ $cartCount }}</span>
                            @endif
                        </span>
                        <a href="{{ route('orders.index') }}" class="px-link {{ request()->routeIs('orders.*') ? 'px-link-active' : '' }}">ORDERS</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-link {{ request()->is('admin*') ? 'px-link-active' : '' }}" style="color:var(--px-yellow);">SITE ADMIN</a>
                        @endif
                    @endauth
                </nav>
                <div class="ms-auto flex items-center gap-3">
                    @auth
                        <span class="px-muted text-[.55rem] tracking-[2px] uppercase">{{ auth()->user()->name }}</span>
                        @if(!request()->is('admin*'))
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button class="px-btn" type="submit">LOGOUT</button>
                            </form>
                        @endif
                    @else
                        <a class="px-btn" href="{{ route('login') }}">LOGIN</a>
                        @if (Route::has('register'))
                            <a class="px-btn" href="{{ route('register') }}">REGISTER</a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>
        @endif

        <main class="px-container" @if(request()->is('admin*')) style="padding:0;margin:0;max-width:none;" @endif>
            @yield('content')
        </main>

        @if(!request()->is('admin*'))
        <div class="px-seafloor"></div>
        <footer class="px-footer">
            <div>POKÉSTOP PIXEL ARCHIVE • © 2025</div>
            <span>Not affiliated with Nintendo / GAME FREAK</span>
        </footer>
        @endif
        <livewire:scripts />
    </body>
</html>
