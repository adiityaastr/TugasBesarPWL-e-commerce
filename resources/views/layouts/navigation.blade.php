<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-8">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-[#0b5c2c]">
                    HerbaMart
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden sm:flex flex-1 max-w-2xl">
                <div class="relative w-full">
                    <input type="text" class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:border-[#0b5c2c] focus:ring-1 focus:ring-[#0b5c2c]" placeholder="Cari obat herbal, jamu, suplemen...">
                    <button class="absolute right-0 top-0 bottom-0 px-4 bg-gray-100 rounded-r-lg border-l border-gray-300 text-gray-500 hover:bg-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Right Side Icons & User -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <!-- Cart Icon (hidden for admin) -->
                @if(!Auth::check() || Auth::user()->role !== 'admin')
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-[#0b5c2c] transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @auth
                            @php $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity'); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-amber-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        @endauth
                    </a>
                @endif

                <div class="h-6 w-px bg-gray-300 mx-2"></div>

                @auth
                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 hover:bg-gray-50 rounded-lg p-1 transition duration-150 ease-in-out focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-gray-200 overflow-hidden shrink-0 border border-gray-300">
                                    <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="text-sm font-medium text-gray-700 truncate max-w-[100px]">{{ Auth::user()->name }}</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')">{{ __('Admin Panel') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.products.create')">{{ __('Tambah Produk') }}</x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('dashboard')">{{ __('My Orders') }}</x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" class="px-3 py-1.5 border border-[#0b5c2c] text-[#0b5c2c] font-bold rounded text-sm hover:bg-green-50">Masuk</a>
                        <a href="{{ route('register') }}" class="px-3 py-1.5 bg-[#0b5c2c] text-white font-bold rounded text-sm hover:bg-[#0a4a24]">Daftar</a>
                    </div>
                @endauth
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
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t">
        <div class="px-4 pt-2 pb-3">
             <input type="text" class="w-full border border-gray-300 rounded mb-3 px-3 py-2" placeholder="Search...">
             @auth
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                <div class="mt-3 space-y-1">
                     @if(Auth::user()->role !== 'admin')
                        <x-responsive-nav-link :href="route('cart.index')">Cart ({{ \App\Models\Cart::where('user_id', Auth::id())->sum('quantity') }})</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')">Transactions</x-responsive-nav-link>
                     @else
                        <x-responsive-nav-link :href="route('admin.dashboard')">Admin Panel</x-responsive-nav-link>
                     @endif
                     <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                    </form>
                </div>
             @else
                <div class="flex flex-col gap-2 mt-2">
                     <a href="{{ route('login') }}" class="block text-center px-4 py-2 border border-[#0b5c2c] text-[#0b5c2c] rounded">Masuk</a>
                    <a href="{{ route('register') }}" class="block text-center px-4 py-2 bg-[#0b5c2c] text-white rounded">Daftar</a>
                </div>
             @endauth
        </div>
    </div>
</nav>
