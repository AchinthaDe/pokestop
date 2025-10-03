<nav x-data="{ open: false }" class="bg-black/40 border-b border-green-400/30 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <div class="w-8 h-8 bg-gray-800 border border-green-400 flex items-center justify-center">
                        <span class="text-green-400 font-bold text-lg font-mono">P</span>
                    </div>
                    <span class="text-green-400 font-mono font-bold text-xl tracking-wider hover:text-cyan-400 transition-colors">
                        POKÉSTOP
                    </span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex items-center space-x-6">
                    <a href="{{ route('home') }}" 
                       class="text-green-400 hover:text-cyan-400 font-mono text-sm transition-colors {{ request()->routeIs('home') ? 'text-cyan-400' : '' }}">
                        [ HOME ]
                    </a>
                    <a href="{{ route('products.browse') }}" 
                       class="text-green-400 hover:text-cyan-400 font-mono text-sm transition-colors {{ request()->routeIs('products.browse') ? 'text-cyan-400' : '' }}">
                        [ BROWSE ]
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="text-yellow-400 hover:text-cyan-400 font-mono text-sm transition-colors {{ request()->is('admin*') ? 'text-cyan-400' : '' }}">
                                [ ADMIN ]
                            </a>
                        @endif
                    @endauth
                </div>
            </div>



            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center space-x-6">
                @auth
                    <!-- Cart -->
                    @php
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())
                            ->withCount('items')
                            ->first()
                            ?->items_count ?? 0;
                    @endphp
                    <a href="{{ route('cart.index') }}" 
                       class="text-green-400 hover:text-cyan-400 font-mono text-sm transition-colors {{ request()->routeIs('cart.index') ? 'text-cyan-400' : '' }}">
                        [ CART 
                        @if($cartCount > 0)
                            <span class="text-yellow-400">({{ $cartCount }})</span>
                        @endif
                        ]
                    </a>

                    <!-- User Menu -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = ! open" 
                                class="text-green-400 hover:text-cyan-400 font-mono text-sm transition-colors flex items-center space-x-1">
                            <span>{{ auth()->user()?->name }}</span>
                            <svg class="w-3 h-3" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             @click.outside="open = false"
                             class="absolute right-0 z-50 mt-2 w-48 bg-black border border-green-400 shadow-lg">
                            
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2 text-sm font-mono text-green-400 hover:text-cyan-400 hover:bg-gray-800 transition-colors">
                                [ PROFILE ]
                            </a>
                            
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="block px-4 py-2 text-sm font-mono text-yellow-400 hover:text-cyan-400 hover:bg-gray-800 transition-colors">
                                    [ ADMIN ]
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm font-mono text-green-400 hover:text-red-400 hover:bg-gray-800 transition-colors">
                                    [ LOGOUT ]
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" 
                           class="text-green-400 hover:text-cyan-400 font-mono text-sm transition-colors">
                            [ LOGIN ]
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="text-green-400 hover:text-cyan-400 font-mono text-sm transition-colors">
                                [ REGISTER ]
                            </a>
                        @endif
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Home
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.browse')" :active="request()->routeIs('products.browse')">
                Browse
            </x-responsive-nav-link>
            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->is('admin*')">
                        Admin
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ auth()->user()?->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()?->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    @if(auth()->user()->isAdmin())
                        <x-responsive-nav-link :href="route('admin.dashboard')">
                            Admin
                        </x-responsive-nav-link>
                    @endif
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endguest
    </div>
</nav>
