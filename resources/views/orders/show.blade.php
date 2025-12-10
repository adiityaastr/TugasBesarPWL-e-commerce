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
                                <button type="button" onclick="toggleReviewModal(true)" class="inline-flex items-center px-4 py-2 bg-[#0b5c2c] hover:bg-[#094520] text-white text-sm font-semibold rounded-lg shadow">
                                    Selesaikan Pesanan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Modal -->
            <div id="review-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleReviewModal(false)"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                        <form action="{{ route('orders.complete', $order) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                                                Beri Ulasan & Selesaikan
                                            </h3>
                                            <button type="button" onclick="toggleReviewModal(false)" class="text-gray-400 hover:text-gray-500">
                                                <span class="sr-only">Close</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 mb-6">
                                                Silakan berikan ulasan untuk produk yang Anda beli sebelum menyelesaikan pesanan.
                                            </p>
                                            
                                            <div class="space-y-8 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                                                @foreach($order->items as $index => $item)
                                                    <div class="border border-gray-100 rounded-xl p-4 bg-gray-50">
                                                        <div class="flex items-center gap-4 mb-4">
                                                            <div class="w-16 h-16 bg-white rounded-lg overflow-hidden shrink-0 border border-gray-200">
                                                                @if($item->product->image)
                                                                    <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover">
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <div class="text-base font-semibold text-gray-900 line-clamp-1">{{ $item->product->name }}</div>
                                                                <div class="text-sm text-gray-500">Qty: {{ $item->quantity }}</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="hidden" name="reviews[{{ $index }}][product_id]" value="{{ $item->product->id }}">
                                                        
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                                                <div class="flex flex-row-reverse justify-end gap-1">
                                                                    @for($i = 5; $i >= 1; $i--)
                                                                        <input type="radio" id="star{{ $index }}-{{ $i }}" name="reviews[{{ $index }}][rating]" value="{{ $i }}" class="peer sr-only" required>
                                                                        <label for="star{{ $index }}-{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors">
                                                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                            </svg>
                                                                        </label>
                                                                    @endfor
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto (Opsional)</label>
                                                                <input type="file" name="reviews[{{ $index }}][image]" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#0b5c2c] hover:file:bg-green-100 transition">
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Ulasan Anda</label>
                                                            <textarea name="reviews[{{ $index }}][comment]" rows="3" class="w-full text-sm border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] shadow-sm" placeholder="Ceritakan pengalaman Anda menggunakan produk ini..."></textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                                <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#0b5c2c] text-base font-medium text-white hover:bg-[#094520] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0b5c2c] sm:w-auto sm:text-sm transition">
                                    Kirim Ulasan & Selesaikan
                                </button>
                                <button type="button" onclick="toggleReviewModal(false)" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition">
                                    Batal
                                </button>
                            </div>
                        </form>
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

        function toggleReviewModal(show) {
            const el = document.getElementById('review-modal');
            if (!el) return;
            el.classList.toggle('hidden', !show);
        }
    </script>
</x-app-layout>
