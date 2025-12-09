<x-app-layout>
    <div class="mb-8">
        <div class="rounded-xl overflow-hidden shadow-sm mb-8 relative bg-gradient-to-r from-[#f1f8f3] to-[#e3f1e6] text-[#0b5c2c] border border-[#d7e7db]">
            <div class="absolute inset-0 opacity-25 bg-[url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1400&q=60')] bg-cover bg-center"></div>
            <div class="relative px-6 py-12 md:px-10 lg:px-16 lg:py-14">
                <p class="uppercase text-xs font-semibold tracking-[0.2em] mb-2 text-[#0b5c2c]">HerbaMart</p>
                <h1 class="text-3xl md:text-4xl font-bold mb-3 text-[#0b5c2c]">Obat Herbal, Jamu, & Suplemen Alami</h1>
                <p class="max-w-2xl text-[#1f2d1f] mb-6">Pilihan herbal terkurasi: madu murni, jamu tradisional, minyak atsiri, teh herbal, dan suplemen alami untuk daya tahan tubuh.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#kategori-herbal" class="inline-flex items-center px-5 py-3 bg-[#0b5c2c] text-white font-semibold rounded-lg shadow-lg border border-[#06401b] hover:bg-[#09481f] hover:border-[#09481f] transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0b5c2c]">
                        Jelajahi Kategori
                    </a>
                    <a href="#produk-herbal" class="inline-flex items-center px-5 py-3 bg-white text-[#0b5c2c] font-semibold rounded-lg shadow border border-[#0b5c2c] hover:bg-[#0b5c2c] hover:text-white transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0b5c2c]">
                        Produk Unggulan
                    </a>
                </div>
            </div>
        </div>

        <div id="product-area">
        <div id="kategori-herbal" class="mb-10 p-6 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-xl text-gray-900">Kategori Herbal</h3>
                @if(!empty($selectedCategories))
                    <a href="{{ route('home') }}" class="text-sm text-[#0b5c2c] font-semibold hover:underline">Reset</a>
                @endif
            </div>
            @php
                $catIcons = [
                    'Jamu Tradisional' => '<path d="M8 3h8v2H8V3Zm4 14a4 4 0 0 0 4-4V9a4 4 0 1 0-8 0v4a4 4 0 0 0 4 4Zm-6 0h12v2H6v-2Z"/>',
                    'Suplemen Alami' => '<path d="M5 5a5 5 0 0 1 10 0v10a5 5 0 1 1-10 0V5Zm8 0a3 3 0 0 0-6 0v10a3 3 0 1 0 6 0V5Zm4.5 2H18a2 2 0 0 0-2 2v8a4 4 0 0 0 4 4v-2a2 2 0 0 1-2-2v-4h2v-2h-2V9.5a.5.5 0 0 1 .5-.5H21V7h-3.5Z"/>',
                    'Madu & Propolis' => '<path d="M12 2 6 5v6c0 3.9 2.4 7.6 6 9 3.6-1.4 6-5.1 6-9V5l-6-3Zm0 2.2 4 2v4.8c0 2.8-1.6 5.5-4 6.7-2.4-1.2-4-3.9-4-6.7V6.2l4-2Z"/>',
                    'Teh & Infus Herbal' => '<path d="M6 5h12v6a6 6 0 0 1-6 6H8a4 4 0 0 1-4-4V5h2Zm2 10h2a4 4 0 0 0 4-4V7H8v8Zm10-8h2v4a5 5 0 0 1-5 5h-1v-2h1a3 3 0 0 0 3-3V7Z"/>',
                    'Minyak Atsiri' => '<path d="M12 2 8 8v7a4 4 0 0 0 8 0V8l-4-6Zm0 3.2 2 3V15a2 2 0 0 1-4 0V8.2l2-3ZM7 21h10v-2H7v2Z"/>',
                    'Aromaterapi' => '<path d="M10 2h4l-1 3 1 3h-4l1-3-1-3Zm-3 8h10l-1.5 8h-7L7 10Zm2.2 2 1 6h3.6l1-6h-5.6Z"/>',
                ];
            @endphp
            <form method="GET" action="{{ route('home') }}" id="category-form" class="flex flex-wrap gap-2">
                @forelse($categories as $cat)
                    @php $checked = $selectedCategories && $selectedCategories->contains($cat); @endphp
                    <label class="inline-flex items-center gap-2 px-3 py-2 border rounded-full text-sm font-semibold cursor-pointer transition
                        {{ $checked ? 'border-[#0b5c2c] bg-green-50 text-[#0b5c2c]' : 'border-gray-200 text-gray-700 hover:border-[#0b5c2c] hover:text-[#0b5c2c]' }}">
                        <input type="checkbox" name="categories[]" value="{{ $cat }}" class="sr-only" {{ $checked ? 'checked' : '' }} onchange="document.getElementById('category-form').submit();">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            {!! $catIcons[$cat] ?? '<path d="M5 12c0-3.87 3.13-7 7-7a7 7 0 0 1 6.93 6.06c-1.14.7-2.51 1.32-3.93 1.32-1.27 0-2.29-.53-3-1.17-.71.64-1.73 1.17-3 1.17-1.23 0-2.57-.58-3.7-1.26-.15.62-.3 1.28-.3 1.88 0 2.55 1.33 4.9 3.4 6.22l.57.37-.23.59c-.35.91-1.18 1.82-2.4 2.73 3.11-.1 5.31-1.08 6.6-3.03a6.98 6.98 0 0 0 3.06-5.86c0-.52-.05-1.04-.14-1.56.49-.1.98-.25 1.46-.44.33-.13.65-.28.97-.44A7 7 0 0 1 12 19c-3.87 0-7-3.13-7-7Z"/>' !!}
                        </svg>
                        <span class="whitespace-nowrap">{{ $cat }}</span>
                    </label>
                @empty
                    <div class="text-sm text-gray-500">Belum ada kategori.</div>
                @endforelse
            </form>
        </div>

        <h3 id="produk-herbal" class="font-bold text-xl mb-4 text-gray-800">Produk Herbal Terbaru</h3>
        <div class="flex items-center justify-between mb-3 gap-3">
            <div class="text-sm text-gray-600">Urutkan:</div>
            <form method="GET" action="{{ route('home') }}" class="flex items-center gap-2">
                @foreach($selectedCategories ?? [] as $cat)
                    <input type="hidden" name="categories[]" value="{{ $cat }}">
                @endforeach
                <select name="sort" class="text-sm border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c]" onchange="this.form.submit()">
                    <option value="latest" {{ ($selectedSort ?? 'latest') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_desc" {{ ($selectedSort ?? '') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="price_asc" {{ ($selectedSort ?? '') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="best_selling" {{ ($selectedSort ?? '') === 'best_selling' ? 'selected' : '' }}>Penjualan Terbanyak</option>
                    <option value="rating" {{ ($selectedSort ?? '') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
                <noscript><button type="submit" class="px-3 py-1 text-sm bg-[#0b5c2c] text-white rounded">Terapkan</button></noscript>
            </form>
        </div>

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
                        <a href="{{ route('products.show', $product) }}" class="text-sm text-gray-900 leading-snug mb-1 line-clamp-2 hover:text-[#0b5c2c] no-underline">
                            {{ $product->name }}
                        </a>
                        <div class="font-bold text-[#212121] mb-1">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <div class="flex items-center text-xs text-gray-500 mb-2 mt-auto">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Jakarta Pusat
                        </div>
                        <div class="flex items-center text-xs text-gray-500 mb-3">
                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            <span class="ml-1 text-gray-600">4.8 | Terjual 100+</span>
                        </div>

                        @auth
                            @if(Auth::user()->role !== 'admin')
                            <form action="{{ route('cart.store') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full block text-center px-3 py-1.5 border border-[#0b5c2c] text-[#0b5c2c] font-bold rounded text-xs hover:bg-green-50 transition">
                                    + Keranjang
                                </button>
                            </form>
                                <form action="{{ route('cart.store') }}" method="POST" class="w-full mt-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="redirect_to" value="checkout">
                                    <button type="submit" class="w-full block text-center px-3 py-1.5 bg-[#0b5c2c] text-white font-bold rounded text-xs hover:bg-[#09481f] transition">
                                        Beli Langsung
                                    </button>
                                </form>
                            @else
                                <div class="text-xs text-gray-500 font-semibold">Mode admin - katalog saja</div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full block text-center px-3 py-1.5 border border-[#0b5c2c] text-[#0b5c2c] font-bold rounded text-xs hover:bg-green-50 transition">
                                Masuk untuk membeli
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
        </div>
    </div>
</x-app-layout>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const productArea = document.getElementById('product-area');
    const categoryForm = document.getElementById('category-form');

    async function ajaxLoad(url) {
        if (!productArea) return;
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newArea = doc.getElementById('product-area');
        if (newArea) {
            productArea.innerHTML = newArea.innerHTML;
            attachHandlers();
        } else {
            location.href = url; // fallback
        }
    }

    function attachHandlers() {
        // Category checkboxes
        document.querySelectorAll('#category-form input[type="checkbox"]').forEach(cb => {
            cb.addEventListener('change', (e) => {
                e.preventDefault();
                const form = document.getElementById('category-form');
                if (form) {
                    ajaxLoad(form.action + '?' + new URLSearchParams(new FormData(form)).toString());
                }
            });
        });
        // Sort form
        document.querySelectorAll('form[action="{{ route('home') }}"] select[name="sort"]').forEach(sel => {
            sel.addEventListener('change', (e) => {
                const form = sel.closest('form');
                if (form) {
                    ajaxLoad(form.action + '?' + new URLSearchParams(new FormData(form)).toString());
                }
            });
        });
        // Pagination links
        productArea.querySelectorAll('.pagination a, .page-link, nav[role="navigation"] a').forEach(a => {
            a.addEventListener('click', (ev) => {
                ev.preventDefault();
                ajaxLoad(a.href);
            });
        });
        // Add to cart forms
        productArea.querySelectorAll('form[action="{{ route('cart.store') }}"]').forEach(form => {
            form.addEventListener('submit', async (ev) => {
                ev.preventDefault();
                const data = new FormData(form);
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: data
                });
                if (res.ok) {
                    const json = await res.json().catch(() => ({}));
                    if (json.cartCount !== undefined) {
                        const badge = document.querySelector('[data-cart-count]');
                        if (badge) {
                            badge.textContent = json.cartCount;
                            badge.classList.toggle('hidden', json.cartCount <= 0);
                        }
                    }
                    alert(json.message || 'Ditambahkan ke keranjang');
                } else {
                    alert('Gagal menambahkan ke keranjang');
                }
            });
        });
    }

    attachHandlers();
});
</script>
