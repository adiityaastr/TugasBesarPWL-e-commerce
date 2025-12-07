<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel Ecommerce') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <h3 class="font-bold text-lg text-[#03AC0E] mb-4">TokopediaClone</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Situs jual beli online terlengkap dengan berbagai pilihan toko online terpercaya. Belanja online mudah dan aman di TokopediaClone.
                            </p>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-4">Tentang Kami</h4>
                            <ul class="space-y-2 text-sm text-gray-500">
                                <li><a href="#" class="hover:text-[#03AC0E]">Hak Kekayaan Intelektual</a></li>
                                <li><a href="#" class="hover:text-[#03AC0E]">Karir</a></li>
                                <li><a href="#" class="hover:text-[#03AC0E]">Blog</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-4">Bantuan</h4>
                            <ul class="space-y-2 text-sm text-gray-500">
                                <li><a href="#" class="hover:text-[#03AC0E]">Tokopedia Care</a></li>
                                <li><a href="#" class="hover:text-[#03AC0E]">Syarat & Ketentuan</a></li>
                                <li><a href="#" class="hover:text-[#03AC0E]">Kebijakan Privasi</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-4">Ikuti Kami</h4>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-[#03AC0E]"><span class="sr-only">Facebook</span>FB</a>
                                <a href="#" class="text-gray-400 hover:text-[#03AC0E]"><span class="sr-only">Instagram</span>IG</a>
                                <a href="#" class="text-gray-400 hover:text-[#03AC0E]"><span class="sr-only">Twitter</span>TW</a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-gray-200 pt-8 text-center text-sm text-gray-400">
                        &copy; 2025 TokopediaClone. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
