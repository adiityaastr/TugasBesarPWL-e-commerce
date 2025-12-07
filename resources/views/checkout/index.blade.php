<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Pengiriman</h1>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left: Shipping & Payment -->
                    <div class="lg:flex-1">
                        <!-- Address Section -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#03AC0E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Alamat Pengiriman
                            </h2>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Penerima</label>
                                <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 font-medium">
                                    {{ Auth::user()->name }} <span class="text-gray-400 font-normal">({{ Auth::user()->email }})</span>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="shipping_address" class="block text-gray-700 text-sm font-semibold mb-2">Alamat Lengkap</label>
                                <textarea id="shipping_address" name="shipping_address" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-[#03AC0E] focus:border-[#03AC0E]" placeholder="Tulis nama jalan, nomor rumah, RT/RW, kelurahan, dll..." required></textarea>
                            </div>
                        </div>

                         <!-- Payment Method -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#03AC0E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Pilih Pembayaran
                            </h2>

                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[#03AC0E] hover:bg-green-50 transition">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="h-4 w-4 text-[#03AC0E] focus:ring-[#03AC0E] border-gray-300" checked>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-900">Transfer Virtual Account</span>
                                        <span class="block text-xs text-gray-500">BCA, Mandiri, BNI, BRI</span>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[#03AC0E] hover:bg-green-50 transition">
                                    <input type="radio" name="payment_method" value="credit_card" class="h-4 w-4 text-[#03AC0E] focus:ring-[#03AC0E] border-gray-300">
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-900">Kartu Kredit / Debit Online</span>
                                        <span class="block text-xs text-gray-500">Visa, Mastercard, JCB</span>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[#03AC0E] hover:bg-green-50 transition">
                                    <input type="radio" name="payment_method" value="cod" class="h-4 w-4 text-[#03AC0E] focus:ring-[#03AC0E] border-gray-300">
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-900">COD (Bayar di Tempat)</span>
                                        <span class="block text-xs text-gray-500">Bayar tunai kepada kurir</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Summary -->
                    <div class="lg:w-96">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                            <h3 class="font-bold text-lg text-gray-900 mb-4">Ringkasan Belanja</h3>
                            
                            @php $total = 0; @endphp
                            <div class="space-y-3 mb-4 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                @foreach($cartItems as $item)
                                    @php $total += $item->product->price * $item->quantity; @endphp
                                    <div class="flex justify-between text-sm">
                                        <div class="text-gray-600 truncate w-40">{{ $item->product->name }} ({{ $item->quantity }}x)</div>
                                        <div class="font-medium text-gray-900">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-100 my-4 pt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Total Harga</span>
                                    <span class="font-bold text-gray-900">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-600">Ongkos Kirim</span>
                                    <span class="text-[#03AC0E] font-medium">Bebas Ongkir</span>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <span class="font-bold text-lg text-gray-900">Total Tagihan</span>
                                    <span class="font-bold text-xl text-[#03AC0E]">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-[#03AC0E] hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                                Bayar Sekarang
                            </button>
                            <p class="text-xs text-center text-gray-400 mt-3">
                                Dengan membayar, saya menyetujui Syarat & Ketentuan yang berlaku.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
