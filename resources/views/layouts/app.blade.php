<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Multi-Vendor E-commerce</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-teal-700">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}" class="text-white text-xl font-bold">Ecommerce</a>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="{{ route('home') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Home</a>
                                <a href="{{ route('products.index') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Products</a>
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Admin</a>
                                    @elseif(auth()->user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Seller Panel</a>
                                    @else
                                        <a href="{{ route('customer.dashboard') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6 space-x-4">
                            @auth
                                <a href="{{ route('chat.index') }}" class="text-teal-100 hover:text-white" title="Messages">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="text-teal-100 hover:text-white" title="Wishlist">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('cart.index') }}" class="text-teal-100 hover:text-white" title="Cart">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('orders.index') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Orders</a>
                                <a href="{{ route('profile.edit') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">{{ auth()->user()->name }}</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-teal-100 hover:bg-teal-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Login</a>
                                <a href="{{ route('register') }}" class="bg-emerald-600 text-white hover:bg-emerald-700 rounded-md px-3 py-2 text-sm font-medium">Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-teal-700 text-white mt-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">About Us</h3>
                        <p class="text-teal-100">Multi-vendor e-commerce platform for buying and selling products online.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-teal-100 hover:text-white">Home</a></li>
                            <li><a href="{{ route('products.index') }}" class="text-teal-100 hover:text-white">Products</a></li>
                            @auth
                                <li><a href="{{ route('tickets.create') }}" class="text-teal-100 hover:text-white">Support</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Become a Seller</h3>
                        @guest
                            <p class="text-teal-100">Register and start selling your products today!</p>
                        @else
                            @if(!auth()->user()->seller)
                                <a href="{{ route('seller.register') }}" class="text-emerald-300 hover:text-emerald-200">Register as Seller</a>
                            @endif
                        @endguest
                    </div>
                </div>
                <div class="mt-8 border-t border-teal-600 pt-8 text-center text-teal-100">
                    <p>&copy; {{ date('Y') }} Ecommerce. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
