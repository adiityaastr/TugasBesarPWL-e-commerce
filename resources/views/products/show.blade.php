<x-app-layout>
    <div class="py-8 bg-white">
        <div id="product-data" class="hidden" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <div class="text-sm text-gray-500 mb-4 flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-[#0b5c2c]">Home</a>
                <span>/</span>
                <span class="text-gray-800 font-medium truncate">{{ $product->name }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Left: Image Gallery (Static for now) -->
                <div class="lg:col-span-5">
                    <div class="rounded-xl overflow-hidden border border-gray-100 sticky top-24">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
                        @else
                            <div class="w-full h-[400px] bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Middle: Product Info -->
                <div class="lg:col-span-4">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2 leading-tight">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                        <span>Terjual <span class="text-gray-700">100+</span></span>
                        <span>•</span>
                        <div class="flex items-center text-yellow-400">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            <span class="text-gray-700 ml-1">4.8</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="text-3xl font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>

                    <div class="border-t border-b border-gray-100 py-4 mb-6">
                        <h3 class="font-bold text-[#0b5c2c] text-sm mb-2">Detail Produk Herbal</h3>
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                            {{ $product->description }}
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                         <img src="https://ui-avatars.com/api/?name=HerbaMart+Store&background=0b5c2c&color=fff" class="w-10 h-10 rounded-full" alt="Store">
                         <div>
                             <div class="font-bold text-sm text-gray-800">HerbaMart Official</div>
                             <div class="text-xs text-[#0b5c2c] font-medium">• Online | Produk terkurasi</div>
                         </div>
                    </div>
                </div>

                <!-- Right: Purchase Card -->
                <div class="lg:col-span-3">
                    <div class="border border-gray-200 rounded-xl p-4 shadow-sm sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-4">Atur jumlah dan catatan</h3>
                        
                        @auth
                            @if(Auth::user()->role !== 'admin')
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <div class="flex items-center border border-gray-300 rounded mb-4 w-max">
                                            <button type="button" onclick="decrement()" class="px-3 py-1 text-gray-700 hover:bg-green-50 rounded-l">-</button>
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center border-none p-1 text-sm focus:ring-0 text-gray-900">
                                            <button type="button" onclick="increment()" class="px-3 py-1 text-[#0b5c2c] hover:bg-green-50 rounded-r">+</button>
                                        </div>
                                        <p class="text-xs text-gray-500 mb-4">Stok Total: <span class="font-bold text-gray-700">{{ $product->stock }}</span></p>

                                        <div class="flex items-center justify-between mb-6">
                                            <span class="text-gray-600 text-sm">Subtotal</span>
                                            <span class="font-bold text-lg text-gray-900" id="subtotal">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="flex flex-col gap-2">
                                            <button type="submit" class="w-full bg-[#0b5c2c] hover:bg-[#0a4a24] text-white font-bold py-2.5 rounded-lg transition">
                                                + Keranjang
                                            </button>
                                        </div>
                                    </form>
                                    <form action="{{ route('cart.store') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" id="quantity-buy-now" value="1">
                                        <input type="hidden" name="redirect_to" value="checkout">
                                        <button type="submit" class="w-full border border-[#0b5c2c] text-[#0b5c2c] hover:bg-[#0b5c2c] hover:text-white font-bold py-2.5 rounded-lg transition">
                                            Beli Langsung
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-gray-100 text-gray-500 text-center py-4 rounded-lg font-bold">
                                        Stok Habis
                                    </div>
                                @endif
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm rounded-lg p-4">
                                    Mode admin: hanya melihat detail produk, tidak dapat membeli.
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full bg-[#0b5c2c] hover:bg-[#0a4a24] text-white font-bold py-2.5 rounded-lg text-center transition">
                                Masuk untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const productDataEl = document.getElementById('product-data');
        const price = Number(productDataEl?.dataset.price || 0);
        const stock = Number(productDataEl?.dataset.stock || 0);
        const qtyInput = document.getElementById('quantity');
        const qtyBuyNowInput = document.getElementById('quantity-buy-now');
        const subtotalEl = document.getElementById('subtotal');

        function formatRupiah(num) {
            return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateSubtotal() {
            if(!qtyInput) return;
            let qty = parseInt(qtyInput.value);
            if(qty < 1) qty = 1;
            if(qty > stock) qty = stock;
            qtyInput.value = qty;
            // Update quantity-buy-now juga agar sinkron
            if(qtyBuyNowInput) {
                qtyBuyNowInput.value = qty;
            }
            if(subtotalEl) {
                subtotalEl.innerText = formatRupiah(qty * price);
            }
        }

        function increment() {
            if(!qtyInput) return;
            qtyInput.stepUp();
            updateSubtotal();
        }

        function decrement() {
            if(!qtyInput) return;
            qtyInput.stepDown();
            updateSubtotal();
        }
        
        if(qtyInput) {
            qtyInput.addEventListener('change', updateSubtotal);
        }
    </script>
</x-app-layout>
