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

            <form method="GET" action="{{ route('home') }}" id="category-form" class="flex flex-wrap gap-3">
                @forelse($categories as $cat)
                    @php $checked = $selectedCategories && $selectedCategories->contains($cat); @endphp
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 border-2 rounded-lg text-sm font-semibold cursor-pointer transition-all duration-200
                        {{ $checked ? 'border-[#0b5c2c] bg-green-50 text-[#0b5c2c] shadow-sm' : 'border-gray-200 bg-white text-gray-700 hover:border-[#0b5c2c] hover:bg-green-50 hover:text-[#0b5c2c]' }}">
                        <input type="checkbox" name="categories[]" value="{{ $cat }}" class="sr-only" {{ $checked ? 'checked' : '' }} onchange="document.getElementById('category-form').submit();">
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
                const redirectTo = data.get('redirect_to');
                
                // Jika redirect_to adalah 'checkout', langsung redirect
                if (redirectTo === 'checkout') {
                    form.submit();
                    return;
                }
                
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
                        updateCartBadge(json.cartCount);
                    }
                    // Buka modal notifikasi setelah berhasil menambahkan
                    if (typeof openCartNotificationModal === 'function') {
                        openCartNotificationModal();
                    } else {
                        alert(json.message || 'Ditambahkan ke keranjang');
                    }
                } else {
                    alert('Gagal menambahkan ke keranjang');
                }
            });
        });
    }

    attachHandlers();
});

// Global function to update cart badge
function updateCartBadge(count) {
    const badge = document.querySelector('[data-cart-count]');
    if (badge) {
        badge.textContent = count;
        badge.classList.toggle('hidden', count <= 0);
    }
}
</script>
