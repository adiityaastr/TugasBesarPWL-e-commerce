<x-app-layout>
    <!-- Hero Section -->
    <div class="mb-8">
        <!-- Banner Carousel (Static for MVP) -->
        <div class="rounded-xl overflow-hidden shadow-sm mb-8 relative">
            <img src="/hero-placeholder.svg" alt="Promo Banner" class="w-full h-auto min-h-[300px] object-cover">
            <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                <div class="w-2 h-2 rounded-full bg-white opacity-100 shadow"></div>
                <div class="w-2 h-2 rounded-full bg-white opacity-50 shadow"></div>
                <div class="w-2 h-2 rounded-full bg-white opacity-50 shadow"></div>
            </div>
        </div>

        <!-- Categories -->
        <div class="mb-10 p-6 bg-white rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-xl mb-6 text-gray-800">Kategori Pilihan</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                @foreach([
                    ['name' => 'Elektronik', 'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                    ['name' => 'Fashion', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'], // Generic User/Fashion
                    ['name' => 'Gaming', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
                    ['name' => 'Rumah Tangga', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['name' => 'Kesehatan', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                    ['name' => 'Otomotif', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'] // Exchange
                ] as $cat)
                <div class="flex flex-col items-center justify-center p-4 border rounded-lg hover:shadow-md hover:border-[#03AC0E] cursor-pointer transition group">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-2 group-hover:bg-green-50 transition">
                         <svg class="w-6 h-6 text-gray-500 group-hover:text-[#03AC0E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}"></path></svg>
                    </div>
                    <span class="text-sm text-gray-600 font-medium group-hover:text-[#03AC0E]">{{ $cat['name'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Product Grid -->
        <h3 class="font-bold text-xl mb-4 text-gray-800">Traktir Pengguna Baru</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-200 border border-gray-100 flex flex-col h-full">
                    <a href="{{ route('products.show', $product) }}" class="block relative group">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-lg">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400 rounded-t-lg">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </a>

                    <div class="p-3 flex flex-col flex-grow">
                        <a href="{{ route('products.show', $product) }}" class="text-sm text-gray-800 leading-snug mb-1 line-clamp-2 hover:text-[#03AC0E] no-underline">
                            {{ $product->name }}
                        </a>
                        <div class="font-bold text-[#212121] mb-1">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <!-- Mock Location -->
                        <div class="flex items-center text-xs text-gray-500 mb-2 mt-auto">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Jakarta Pusat
                        </div>
                        
                        <!-- Rating Placeholder -->
                        <div class="flex items-center text-xs text-gray-500 mb-3">
                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            <span class="ml-1 text-gray-600">4.8 | Terjual 100+</span>
                        </div>

                        @auth
                            <form action="{{ route('cart.store') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full block text-center px-3 py-1.5 border border-[#03AC0E] text-[#03AC0E] font-bold rounded text-xs hover:bg-green-50 transition">
                                    + Keranjang
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
