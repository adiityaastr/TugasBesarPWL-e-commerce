<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>
            
            @if($cartItems->isEmpty())
                <div class="bg-white rounded-xl p-12 text-center shadow-sm">
                    <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/1c70e7e0.svg" alt="Empty Cart" class="w-48 mx-auto mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Wah, keranjang belanjamu kosong</h2>
                    <p class="text-gray-500 mb-6">Yuk, isi dengan barang-barang impianmu!</p>
                    <a href="{{ route('home') }}" class="inline-block bg-[#03AC0E] text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Cart Items -->
                    <div class="lg:flex-1">
                         <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                             <!-- Header -->
                             <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                                <input type="checkbox" checked class="rounded text-[#03AC0E] focus:ring-[#03AC0E]">
                                <span class="font-semibold text-gray-700">Pilih Semua</span>
                             </div>

                             @php $total = 0; @endphp
                             @foreach($cartItems as $item)
                                @php $itemTotal = $item->product->price * $item->quantity; $total += $itemTotal; @endphp
                                <div class="p-6 border-b border-gray-100 last:border-none">
                                    <div class="flex items-start gap-4">
                                        <input type="checkbox" checked class="mt-1 rounded text-[#03AC0E] focus:ring-[#03AC0E]">
                                        
                                        <!-- Image -->
                                        <div class="w-20 h-20 shrink-0">
                                            @if($item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover rounded-md" alt="{{ $item->product->name }}">
                                            @else
                                                <div class="w-full h-full bg-gray-100 rounded-md flex items-center justify-center text-gray-400">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Info -->
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 mb-1">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500 mb-3">{{ $item->product->description }}</p>
                                            <div class="font-bold text-gray-900">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex justify-end items-center mt-4 gap-4">
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center border border-gray-300 rounded-lg">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l disabled:opacity-50" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                            <input type="text" readonly value="{{ $item->quantity }}" class="w-10 text-center border-none p-1 text-sm focus:ring-0">
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-3 py-1 text-[#03AC0E] hover:bg-gray-100 rounded-r">+</button>
                                        </form>
                                    </div>
                                </div>
                             @endforeach
                         </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="lg:w-96">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                            <h3 class="font-bold text-lg text-gray-800 mb-6">Ringkasan Belanja</h3>
                            
                            <div class="flex justify-between items-center mb-4 text-gray-600">
                                <span>Total Harga ({{ $cartItems->sum('quantity') }} barang)</span>
                                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="border-t border-gray-100 my-4"></div>
                            
                            <div class="flex justify-between items-center mb-8">
                                <span class="font-bold text-lg text-gray-900">Total Tagihan</span>
                                <span class="font-bold text-lg text-[#03AC0E]">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full bg-[#03AC0E] hover:bg-green-700 text-white font-bold py-3 rounded-lg text-center shadow-lg transition transform hover:-translate-y-1">
                                Beli ({{ $cartItems->sum('quantity') }})
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
