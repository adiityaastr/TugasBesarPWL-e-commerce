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
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm font-semibold text-gray-900">{{ $order->order_number ?? '#'.$order->id }}</td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm text-gray-700">{{ $order->user->name }}</td>
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
                                                <span class="text-xs text-gray-500">Pesanan selesai</span>
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
