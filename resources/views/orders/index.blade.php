<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Riwayat Pesanan</h2>
                            <p class="text-sm text-gray-600">Lihat status dan detail pesanan kamu.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm leading-normal">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <th class="px-4 py-3">Order</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($orders as $order)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3 font-semibold text-[#0b5c2c]">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                                @if($order->status == 'cancelled') bg-red-100 text-red-700
                                                @elseif($order->status == 'pending_cancellation') bg-orange-100 text-orange-700
                                                @elseif($order->status == 'pengiriman') bg-blue-100 text-blue-700
                                                @elseif($order->status == 'pengemasan') bg-purple-100 text-purple-700
                                                @elseif($order->status == 'proses') bg-yellow-100 text-yellow-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                @if($order->status == 'pending_cancellation')
                                                    Menunggu Konfirmasi
                                                @elseif($order->status == 'proses')
                                                    Proses
                                                @elseif($order->status == 'pengemasan')
                                                    Pengemasan
                                                @elseif($order->status == 'pengiriman')
                                                    Pengiriman
                                                @elseif($order->status == 'cancelled')
                                                    Dibatalkan
                                                @else
                                                    {{ ucfirst($order->status) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-[#0b5c2c] hover:bg-[#09481f] rounded-lg shadow">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                            Belum ada pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
