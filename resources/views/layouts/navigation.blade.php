{{-- resources/views/layouts/navigation.blade.php --}}

<nav x-data="{ open: false }"
     class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100 transition-all duration-300">

    {{-- ========= WRAPPER ========= --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                {{-- ================== LOGO ================== --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        {{-- Logo --}}
                        <img src="{{ asset('image/bcake-icon.png') }}"
                             alt="B'cake logo"
                             class="w-9 h-9 rounded-xl shadow" />

                        <span class="font-semibold text-xl text-rose-800">
                            B’cake
                        </span>
                    </a>
                </div>

                {{-- =============== NAV LINKS (DESKTOP) =============== --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    {{-- Home --}}
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>

                    {{-- Produk --}}
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        Produk
                    </x-nav-link>

                    {{-- Toko --}}
                    @if (Route::has('stores.index'))
                        <x-nav-link :href="route('stores.index')" :active="request()->routeIs('stores.*')">
                            Toko
                        </x-nav-link>
                    @endif

                    {{-- Bantuan --}}
                    @if (Route::has('help'))
                        <x-nav-link :href="route('help')" :active="request()->routeIs('help')">
                            Bantuan
                        </x-nav-link>
                    @endif

                    {{-- Keranjang --}}
                    @if (Route::has('cart.index'))
                        @php $cc = (int) session('cart_count', 0); @endphp
                        <div class="relative">
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                                Keranjang
                            </x-nav-link>

                            @if($cc > 0)
                                <span class="absolute -top-1 -right-3 bg-rose-600 text-white text-[10px] px-1.5 py-[2px] rounded-full">
                                    {{ $cc }}
                                </span>
                            @endif
                        </div>
                    @endif

                </div>
            </div>



            {{-- ================== USER DROPDOWN (Desktop) ================== --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                @auth
                    {{-- Dashboard Button --}}
                    @if(auth()->user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}"
                           class="me-4 px-4 py-1.5 rounded-full bg-rose-100 text-rose-700 text-sm hover:bg-rose-200">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="me-4 px-4 py-1.5 rounded-full bg-rose-100 text-rose-700 text-sm hover:bg-rose-200">
                            Admin
                        </a>
                    @endif

                    {{-- Dropdown --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border text-sm rounded-md bg-white text-gray-600 hover:text-gray-800">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293..."
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">

                            {{-- Profile --}}
                            @if(Route::has('profile.edit'))
                                <x-dropdown-link :href="route('profile.edit')">
                                    Profil
                                </x-dropdown-link>
                            @endif

                            {{-- Logout --}}
                            @if (Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </x-dropdown-link>
                                </form>
                            @endif

                        </x-slot>
                    </x-dropdown>

                @else
                    {{-- Jika belum login --}}
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium hover:text-rose-600">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="ms-4 text-sm font-semibold px-4 py-1.5 bg-rose-600 text-white rounded-full hover:bg-rose-700">
                        Daftar
                    </a>
                @endauth

            </div>



            {{-- ================== HAMBURGER (MOBILE) ================== --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}"
                              class="inline-flex"
                              stroke="currentColor" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}"
                              class="hidden"
                              stroke="currentColor" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>



    {{-- ================== RESPONSIVE MENU ================== --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Home
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                Produk
            </x-responsive-nav-link>

            @if (Route::has('stores.index'))
                <x-responsive-nav-link :href="route('stores.index')" :active="request()->routeIs('stores.*')">
                    Toko
                </x-responsive-nav-link>
            @endif

            @if (Route::has('help'))
                <x-responsive-nav-link :href="route('help')" :active="request()->routeIs('help')">
                    Bantuan
                </x-responsive-nav-link>
            @endif
        </div>



        {{-- ================== USER MOBILE ================== --}}
        <div class="pt-4 pb-1 border-t border-gray-200">

            @auth
                <div class="px-4 mb-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                @if(auth()->user()->role === 'seller')
                    <x-responsive-nav-link :href="route('seller.dashboard')">Dashboard</x-responsive-nav-link>
                @elseif(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')">Admin</x-responsive-nav-link>
                @endif

                @if(Route::has('profile.edit'))
                    <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>
                @endif

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                                          onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-responsive-nav-link>
                </form>

            @else
                <x-responsive-nav-link :href="route('login')">Login</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">Daftar</x-responsive-nav-link>
            @endauth

        </div>

    </div>
</nav>



{{-- ================== SCROLL SHADOW SCRIPT ================== --}}
<script>
    document.addEventListener('scroll', () => {
        const nav = document.querySelector('nav');
        if (window.scrollY > 10) nav.classList.add('shadow-md');
        else nav.classList.remove('shadow-md');
    });
</script>
