<x-admin-layout>
    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h2>
                    <button onclick="window.print()" class="bg-[#0b5c2c] hover:bg-[#09481f] text-white font-semibold py-2 px-6 rounded-lg transition inline-flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Laporan
                    </button>
                </div>
                
                <!-- Filter Form -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900 shadow-sm py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900 shadow-sm py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Status</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900 shadow-sm py-2 px-3">
                                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="pengemasan" {{ request('status') == 'pengemasan' ? 'selected' : '' }}>Pengemasan</option>
                                <option value="pengiriman" {{ request('status') == 'pengiriman' ? 'selected' : '' }}>Pengiriman</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                <option value="pending_cancellation" {{ request('status') == 'pending_cancellation' ? 'selected' : '' }}>Menunggu Pembatalan</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-[#0b5c2c] hover:bg-[#09481f] text-white font-semibold py-2 px-4 rounded-lg transition shadow-sm">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('admin.reports.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg transition text-center shadow-sm">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5 shadow-sm">
                        <div class="text-sm text-green-700 font-semibold mb-2 uppercase tracking-wide">Total Pesanan</div>
                        <div class="text-3xl font-bold text-green-800">{{ $totalOrders }}</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5 shadow-sm">
                        <div class="text-sm text-blue-700 font-semibold mb-2 uppercase tracking-wide">Total Pendapatan</div>
                        <div class="text-2xl font-bold text-blue-800">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5 shadow-sm">
                        <div class="text-sm text-purple-700 font-semibold mb-2 uppercase tracking-wide">Pesanan Dikirim</div>
                        <div class="text-3xl font-bold text-purple-800">{{ $totalShipped }}</div>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-5 shadow-sm">
                        <div class="text-sm text-red-700 font-semibold mb-2 uppercase tracking-wide">Pesanan Dibatalkan</div>
                        <div class="text-3xl font-bold text-red-800">{{ $totalCancelled }}</div>
                    </div>
                </div>
            </div>

            <!-- Tabel Laporan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Pesanan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                                    <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Item</th>
                                    <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 border-b border-gray-100 bg-white text-sm font-semibold text-gray-800">{{ $order->order_number ?? '#'.$order->id }}</td>
                                        <td class="px-4 py-3 border-b border-gray-100 bg-white text-sm text-gray-700">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3 border-b border-gray-100 bg-white text-sm text-gray-700">{{ $order->user->full_name ?? $order->user->name }}</td>
                                        <td class="px-4 py-3 border-b border-gray-100 bg-white text-sm text-gray-700">{{ $order->items->sum('quantity') }} item</td>
                                        <td class="px-4 py-3 border-b border-gray-100 bg-white text-sm font-semibold text-gray-900">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 border-b border-gray-100 bg-white text-sm">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                                @if($order->status === 'cancelled') bg-red-100 text-red-700 
                                                @elseif($order->status === 'pending_cancellation') bg-orange-100 text-orange-700
                                                @elseif($order->status === 'pengiriman') bg-blue-100 text-blue-700
                                                @elseif($order->status === 'pengemasan') bg-purple-100 text-purple-700
                                                @elseif($order->status === 'proses') bg-yellow-100 text-yellow-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                @if($order->status === 'pending_cancellation')
                                                    Menunggu
                                                @elseif($order->status === 'proses')
                                                    Proses
                                                @elseif($order->status === 'pengemasan')
                                                    Pengemasan
                                                @elseif($order->status === 'pengiriman')
                                                    Pengiriman
                                                @elseif($order->status === 'cancelled')
                                                    Dibatalkan
                                                @else
                                                    {{ ucfirst($order->status) }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                            Tidak ada data untuk periode yang dipilih.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, .no-print {
                display: none !important;
            }
            body {
                background: white;
            }
            .bg-gray-50 {
                background: white !important;
            }
        }
    </style>
</x-admin-layout>

