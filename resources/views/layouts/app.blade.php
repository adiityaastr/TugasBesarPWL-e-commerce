<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HerbaMart') }}</title>

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
                            <h3 class="font-bold text-lg text-[#0b5c2c] mb-4">HerbaMart</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Toko obat herbal, jamu, madu, dan suplemen alami terpercaya. Produk terkurasi untuk kesehatan keluarga.
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
                                <li><a href="#" class="hover:text-[#0b5c2c]">Pusat Bantuan</a></li>
                                <li><a href="#" class="hover:text-[#0b5c2c]">Syarat & Ketentuan</a></li>
                                <li><a href="#" class="hover:text-[#0b5c2c]">Kebijakan Privasi</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-4">Ikuti Kami</h4>
                            <div class="flex space-x-4 text-gray-500">
                                <a href="#" class="hover:text-[#0b5c2c]" aria-label="Facebook">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-2.9h2v-2.2c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2v1.9h2.3L14 14.9h-2v7A10 10 0 0 0 22 12Z"/>
                                    </svg>
                                </a>
                                <a href="#" class="hover:text-[#0b5c2c]" aria-label="Instagram">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4Zm0 2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7Zm5 2.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 0 1 12 7.5Zm0 2A2.5 2.5 0 1 0 14.5 12 2.5 2.5 0 0 0 12 9.5Zm5.25-3.75a.75.75 0 1 1-.75.75.75.75 0 0 1 .75-.75Z"/>
                                    </svg>
                                </a>
                                <a href="#" class="hover:text-[#0b5c2c]" aria-label="Twitter">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M22 5.8a6 6 0 0 1-1.8.5 3 3 0 0 0 1.3-1.7 6 6 0 0 1-1.9.7 3 3 0 0 0-5.2 2v.6A8.5 8.5 0 0 1 4 4.7a3 3 0 0 0 .9 4 3 3 0 0 1-1.3-.3v.1a3 3 0 0 0 2.4 3 3 3 0 0 1-1.3.1 3 3 0 0 0 2.8 2 6 6 0 0 1-3.7 1.3H3.5A8.5 8.5 0 0 0 8 18a8.5 8.5 0 0 0 8.6-8.5v-.4A6 6 0 0 0 22 5.8Z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-gray-200 pt-8 text-center text-sm text-gray-400">
                        &copy; 2025 HerbaMart. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
