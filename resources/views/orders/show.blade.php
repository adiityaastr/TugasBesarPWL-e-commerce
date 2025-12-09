<x-app-layout>
    <div class="py-10 bg-gray-50">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="text-sm text-gray-500">Tanggal</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</div>
                            <div class="text-xs text-gray-500 mt-1">Order No: {{ $order->order_number ?? ('#'.$order->id) }}</div>
                            <div class="mt-3">
                                <span class="text-sm text-gray-500">Status</span>
                                <span class="ml-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                    @if($order->status === 'cancelled') bg-red-100 text-red-700
                                    @elseif($order->status === 'pending_cancellation') bg-orange-100 text-orange-700
                                    @elseif($order->status === 'pengiriman') bg-blue-100 text-blue-700
                                    @elseif($order->status === 'pengemasan') bg-purple-100 text-purple-700
                                    @elseif($order->status === 'proses') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    @if($order->status === 'pending_cancellation')
                                        Menunggu Konfirmasi Pembatalan
                                    @elseif($order->status === 'proses')
                                        Proses
                                    @elseif($order->status === 'pengemasan')
                                        Pengemasan
                                    @elseif($order->status === 'pengiriman')
                                        Pengiriman
                                    @elseif($order->status === 'sudah_sampai')
                                        Sudah Sampai
                                    @elseif($order->status === 'cancelled')
                                        Dibatalkan
                                    @else
                                        {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </div>
                            @if($order->status === 'pending_cancellation' && $order->cancellation_reason)
                                <div class="mt-3">
                                    <div class="text-sm text-gray-500 mb-1">Alasan Pembatalan</div>
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 text-sm text-orange-800">
                                        {{ $order->cancellation_reason }}
                                    </div>
                                    <div class="mt-2 text-xs text-orange-600">
                                        ⏳ Menunggu konfirmasi penjual...
                                    </div>
                                </div>
                            @endif
                            @if($order->shipping_address)
                                <div class="mt-3 text-sm text-gray-700">
                                    <div class="font-semibold text-gray-900 mb-1">Alamat Pengiriman</div>
                                    <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
                                        {{ $order->shipping_address }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Total Tagihan</div>
                            <div class="text-2xl font-bold text-[#0b5c2c]">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
                            <div class="mt-3 space-x-2 flex flex-wrap gap-2 justify-end">
                                <a href="{{ route('orders.invoice', $order) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg shadow">
                                    Print Invoice
                                </a>
                                @if($order->status === 'sudah_sampai')
                                <form action="{{ route('orders.complete', $order) }}" method="POST" onsubmit="return confirm('Selesaikan pesanan ini? Pembayaran akan diteruskan ke penjual.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#0b5c2c] hover:bg-[#094520] text-white text-sm font-semibold rounded-lg shadow">
                                        Selesaikan Pesanan
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 md:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Produk</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="py-4 flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 border rounded-lg overflow-hidden flex items-center justify-center text-gray-400 text-xs shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        IMG
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</div>
                                    <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}x</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-600">Harga</div>
                                    <div class="text-sm font-semibold text-gray-900">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500">Subtotal</div>
                                    <div class="text-sm font-semibold text-[#0b5c2c]">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($order->status !== 'cancelled' && $order->status !== 'pending_cancellation')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Aksi Pesanan</h3>
                        <p class="text-sm text-gray-600">Lanjut beli atau ajukan pembatalan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-[#0b5c2c] hover:bg-[#09481f] text-white text-sm font-semibold rounded-lg shadow">
                            Lanjut Belanja
                        </a>
                        <button type="button" onclick="toggleCancelForm(true)" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg shadow">
                            Ajukan Pembatalan
                        </button>
                    </div>
                </div>
            </div>
            @elseif($order->status === 'pending_cancellation')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Aksi Pesanan</h3>
                        <p class="text-sm text-gray-600">Pembatalan sudah diajukan, menunggu konfirmasi penjual.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-[#0b5c2c] hover:bg-[#09481f] text-white text-sm font-semibold rounded-lg shadow">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
            @endif

            @if($order->status !== 'cancelled' && $order->status !== 'pending_cancellation')
            <div id="cancel-form" class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-4 hidden">
                <div class="p-6 md:p-8 space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pembatalan</h3>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="toggleCancelForm(false)" class="text-sm text-gray-500 hover:text-gray-700">Tutup</button>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Berikan alasan pembatalan, lalu kirim permintaan.</p>
                    <form id="cancel-form-inner" action="{{ route('orders.cancel', $order) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Alasan Pembatalan</label>
                        <textarea name="cancellation_reason" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" placeholder="Cth: Salah alamat, ingin mengganti produk, dsb." required></textarea>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg shadow">
                                Kirim Pembatalan
                            </button>
                            <button type="button" onclick="toggleCancelForm(false)" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-semibold rounded-lg hover:bg-gray-50">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        function toggleCancelForm(show) {
            const el = document.getElementById('cancel-form');
            if (!el) return;
            el.classList.toggle('hidden', !show);
        }
    </script>
</x-app-layout>
