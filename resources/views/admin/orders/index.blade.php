<x-admin-layout>
    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Kelola Pesanan</h2>
                        @php
                            $pendingCancellations = \App\Models\Order::where('status', 'pending_cancellation')->count();
                        @endphp
                        @if($pendingCancellations > 0)
                            <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-2">
                                <span class="text-sm font-semibold text-red-700">
                                    ⚠️ {{ $pendingCancellations }} pembatalan menunggu konfirmasi
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Order ID</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm font-semibold text-gray-900">
                                            @if($order->status === 'selesai' && $order->reviews->isNotEmpty())
                                                <button onclick="openReviewModal('{{ $order->id }}')" class="text-[#0b5c2c] hover:underline hover:text-[#094520] focus:outline-none">
                                                    {{ $order->order_number ?? '#'.$order->id }}
                                                </button>
                                            @else
                                                {{ $order->order_number ?? '#'.$order->id }}
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm text-gray-700">{{ $order->user->full_name ?? $order->user->name }}</td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm font-semibold text-gray-900">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($order->status == 'cancelled') bg-red-100 text-red-800 
                                                @elseif($order->status == 'pending_cancellation') bg-orange-100 text-orange-800 
                                                @elseif($order->status == 'pengiriman') bg-blue-100 text-blue-800 
                                                @elseif($order->status == 'pengemasan') bg-purple-100 text-purple-800 
                                                @elseif($order->status == 'proses') bg-yellow-100 text-yellow-800 
                                                @else bg-gray-100 text-gray-800 @endif">
                                                @if($order->status == 'pending_cancellation')
                                                    Menunggu Konfirmasi Pembatalan
                                                @elseif($order->status == 'proses')
                                                    Proses
                                                @elseif($order->status == 'pengemasan')
                                                    Pengemasan
                                                @elseif($order->status == 'pengiriman')
                                                    Pengiriman
                                                @elseif($order->status == 'sudah_sampai')
                                                    Sudah Sampai
                                                @elseif($order->status == 'selesai')
                                                    Selesai
                                                @elseif($order->status == 'cancelled')
                                                    Dibatalkan
                                                @else
                                                    {{ ucfirst($order->status) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm">
                                            @if($order->status === 'pending_cancellation')
                                                <div class="space-y-2">
                                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-2">
                                                        <div class="text-xs font-semibold text-orange-800 mb-1">Alasan Pembatalan:</div>
                                                        <div class="text-xs text-orange-700">{{ $order->cancellation_reason }}</div>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <form action="{{ route('admin.orders.approve-cancellation', $order) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" onclick="return confirm('Setujui pembatalan pesanan ini?')" class="text-xs bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-3 rounded-lg transition">
                                                                Setujui Pembatalan
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.orders.reject-cancellation', $order) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" onclick="return confirm('Tolak pembatalan dan lanjutkan pesanan?')" class="text-xs bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-3 rounded-lg transition">
                                                                Tolak Pembatalan
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @elseif($order->status === 'selesai')
                                                <div class="flex flex-col gap-2">
                                                    <span class="text-xs text-gray-500">Pesanan selesai</span>
                                                    @if($order->reviews->isNotEmpty())
                                                        <!-- Review Modal for Order {{ $order->id }} -->
                                                        <div id="review-modal-{{ $order->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeReviewModal('{{ $order->id }}')"></div>
                                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                        <div class="flex justify-between items-center mb-4">
                                                                            <h3 class="text-lg leading-6 font-bold text-gray-900">
                                                                                Ulasan Pesanan {{ $order->order_number ?? '#'.$order->id }}
                                                                            </h3>
                                                                            <button type="button" onclick="closeReviewModal('{{ $order->id }}')" class="text-gray-400 hover:text-gray-500">
                                                                                <span class="sr-only">Close</span>
                                                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                        
                                                                        <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                                                                            @foreach($order->reviews as $review)
                                                                                <div class="border border-gray-100 rounded-xl p-4 bg-gray-50">
                                                                                    <div class="flex items-start gap-4">
                                                                                        <div class="w-12 h-12 bg-white rounded-lg overflow-hidden shrink-0 border border-gray-200">
                                                                                            @if($review->product->image)
                                                                                                <img src="{{ Storage::url($review->product->image) }}" class="w-full h-full object-cover">
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="flex-1">
                                                                                            <div class="text-sm font-semibold text-gray-900">{{ $review->product->name }}</div>
                                                                                            <div class="flex items-center gap-1 my-1">
                                                                                                @for($i = 1; $i <= 5; $i++)
                                                                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                                                    </svg>
                                                                                                @endfor
                                                                                            </div>
                                                                                            @if($review->comment)
                                                                                                <p class="text-sm text-gray-600 mt-1">"{{ $review->comment }}"</p>
                                                                                            @endif
                                                                                            @if($review->image_path)
                                                                                                <div class="mt-2">
                                                                                                    <img src="{{ Storage::url($review->image_path) }}" class="h-20 w-auto rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition" onclick="window.open(this.src, '_blank')">
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                        <button type="button" onclick="closeReviewModal('{{ $order->id }}')" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition">
                                                                            Tutup
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif($order->status !== 'cancelled')
                                                <div class="flex flex-col gap-2">
                                                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-[#0b5c2c] focus:ring focus:ring-[#0b5c2c] focus:ring-opacity-50 text-gray-700">
                                                            <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                                            <option value="pengemasan" {{ $order->status == 'pengemasan' ? 'selected' : '' }}>Pengemasan</option>
                                                            <option value="pengiriman" {{ $order->status == 'pengiriman' ? 'selected' : '' }}>Pengiriman</option>
                                                            <option value="sudah_sampai" {{ $order->status == 'sudah_sampai' ? 'selected' : '' }}>Sudah sampai</option>
                                                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai (konfirmasi)</option>
                                                            @if($order->status == 'pending_cancellation')
                                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                                            @endif
                                                        </select>
                                                        <button type="submit" class="text-xs bg-[#0b5c2c] hover:bg-[#094520] text-white font-semibold py-2 px-4 rounded-lg transition">
                                                            Update
                                                        </button>
                                                    </form>
                                                    <div>
                                                        <a href="{{ route('admin.orders.label', $order) }}" target="_blank" class="inline-flex items-center gap-2 text-xs bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-3 rounded-lg transition">
                                                            Cetak Resi
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-500">Pesanan dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                            Belum ada pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<script>
    function openReviewModal(orderId) {
        document.getElementById('review-modal-' + orderId).classList.remove('hidden');
    }

    function closeReviewModal(orderId) {
        document.getElementById('review-modal-' + orderId).classList.add('hidden');
    }
</script>
