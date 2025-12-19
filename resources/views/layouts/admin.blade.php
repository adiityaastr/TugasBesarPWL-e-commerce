<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HerbaMart') }} | Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <nav class="bg-white/90 backdrop-blur border-b border-gray-200 shadow-sm sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-[#0b5c2c] font-bold">
                            <img src="{{ asset('images/herbamart-logo.svg') }}" alt="HerbaMart" class="h-8 w-auto object-contain">
                            <span class="text-2xl leading-none">HerbaMart</span>
                        </a>
                        <div class="hidden md:flex gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm font-semibold rounded transition
                                {{ request()->routeIs('admin.dashboard') ? 'text-[#0b5c2c] bg-green-50 border border-green-200' : 'text-gray-700 hover:text-[#0b5c2c] hover:bg-green-50' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-sm font-semibold rounded transition
                                {{ request()->routeIs('admin.products.index') ? 'text-[#0b5c2c] bg-green-50 border border-green-200' : 'text-gray-700 hover:text-[#0b5c2c] hover:bg-green-50' }}">
                                Produk
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 text-sm font-semibold rounded transition
                                {{ request()->routeIs('admin.orders.*') ? 'text-[#0b5c2c] bg-green-50 border border-green-200' : 'text-gray-700 hover:text-[#0b5c2c] hover:bg-green-50' }}">
                                Pesanan
                            </a>
                            <a href="{{ route('admin.complaints.index') }}" class="px-3 py-2 text-sm font-semibold rounded transition
                                {{ request()->routeIs('admin.complaints.*') ? 'text-[#0b5c2c] bg-green-50 border border-green-200' : 'text-gray-700 hover:text-[#0b5c2c] hover:bg-green-50' }}">
                                Komplain
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 text-sm font-semibold rounded transition
                                {{ request()->routeIs('admin.reports.*') ? 'text-[#0b5c2c] bg-green-50 border border-green-200' : 'text-gray-700 hover:text-[#0b5c2c] hover:bg-green-50' }}">
                                Laporan
                            </a>
                            <a href="{{ route('admin.products.create') }}" class="px-3 py-2 text-sm font-semibold rounded transition
                                {{ request()->routeIs('admin.products.create') ? 'text-[#0b5c2c] bg-green-50 border border-green-200' : 'text-gray-700 hover:text-[#0b5c2c] hover:bg-green-50' }}">
                                Tambah Produk
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">Admin</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-white bg-red-500 hover:bg-red-600 px-3 py-2 rounded-md shadow">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md shadow-sm" role="alert">
                        <span class="block sm:inline font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md shadow-sm" role="alert">
                        <span class="block sm:inline font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md shadow-sm">
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>

