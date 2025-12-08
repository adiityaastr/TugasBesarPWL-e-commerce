<x-admin-layout>
    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="text-sm text-gray-500 uppercase font-semibold tracking-wide mb-2">Total Pesanan</div>
                    <div class="text-3xl font-bold text-[#0b5c2c] mb-2">{{ $totalOrders }}</div>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#0b5c2c] hover:text-[#09481f] font-semibold inline-flex items-center gap-1">
                        Lihat semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="text-sm text-gray-500 uppercase font-semibold tracking-wide mb-2">Total Produk</div>
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ $totalProducts }}</div>
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold inline-flex items-center gap-1">
                        Kelola produk <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="text-sm text-gray-500 uppercase font-semibold tracking-wide mb-2">Total Pelanggan</div>
                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ $totalUsers }}</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="text-sm text-gray-500 uppercase font-semibold tracking-wide mb-2">Total Pendapatan</div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">Rp{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-500 mt-1">6 bulan terakhir</div>
                </div>
            </div>

            <!-- Grafik -->
            <div class="flex flex-col lg:flex-row gap-6 justify-center items-start">
                <!-- Grafik Pendapatan per Bulan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 w-full max-w-md mx-auto lg:mx-0">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Pendapatan per Bulan</h3>
                    <div class="h-64">
                        <canvas id="revenueChart" 
                            data-labels="{{ json_encode($revenueLabels ?? []) }}"
                            data-values="{{ json_encode($revenueData ?? []) }}"></canvas>
                    </div>
                </div>

                <!-- Grafik Status Pesanan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 w-full max-w-md mx-auto lg:mx-0">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status Pesanan</h3>
                    <div class="h-64">
                        <canvas id="statusChart" 
                            data-labels="{{ json_encode($statusLabels ?? []) }}"
                            data-values="{{ json_encode($statusData ?? []) }}"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Produk Terlaris -->
            <div class="flex justify-center mt-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 w-full max-w-2xl">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Produk Terlaris (Top 5)</h3>
                    <div class="h-64">
                        <canvas id="productChart" 
                            data-labels="{{ json_encode($productLabels ?? []) }}"
                            data-values="{{ json_encode($productData ?? []) }}"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#0b5c2c] hover:text-[#09481f] font-semibold inline-flex items-center gap-1">
                            Lihat semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                                    <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentOrders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-4 bg-white text-sm font-semibold text-gray-800">#{{ $order->id }}</td>
                                        <td class="px-5 py-4 bg-white text-sm text-gray-700">{{ $order->user->name }}</td>
                                        <td class="px-5 py-4 bg-white text-sm font-semibold text-gray-800">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4 bg-white text-sm">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                                @if($order->status === 'cancelled') bg-red-100 text-red-700 
                                                @elseif($order->status === 'pending_cancellation') bg-orange-100 text-orange-700
                                                @elseif($order->status === 'pengiriman') bg-blue-100 text-blue-700
                                                @elseif($order->status === 'pengemasan') bg-purple-100 text-purple-700
                                                @elseif($order->status === 'proses') bg-yellow-100 text-yellow-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                @if($order->status === 'pending_cancellation')
                                                    Menunggu Konfirmasi
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
                                        <td class="px-5 py-4 bg-white text-sm">
                                            <a href="{{ route('admin.orders.index') }}" class="text-[#0b5c2c] hover:text-[#09481f] font-semibold text-xs">Kelola</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                                            Belum ada pesanan.
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

    <script>
        // Grafik Pendapatan per Bulan
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            const revenueLabels = JSON.parse(revenueCtx.dataset.labels || '[]');
            const revenueData = JSON.parse(revenueCtx.dataset.values || '[]');
            
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: revenueData,
                        borderColor: '#0b5c2c',
                        backgroundColor: 'rgba(11, 92, 44, 0.1)',
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
        }

        // Grafik Status Pesanan
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const statusLabels = JSON.parse(statusCtx.dataset.labels || '[]');
            const statusData = JSON.parse(statusCtx.dataset.values || '[]');
            
            const statusColors = {
                'Proses': 'rgba(234, 179, 8, 0.8)',
                'Pengemasan': 'rgba(168, 85, 247, 0.8)',
                'Pengiriman': 'rgba(59, 130, 246, 0.8)',
                'Pending Cancellation': 'rgba(249, 115, 22, 0.8)',
                'Cancelled': 'rgba(239, 68, 68, 0.8)',
            };

            const statusBgColors = statusLabels.map(function(label) {
                return statusColors[label] || 'rgba(156, 163, 175, 0.8)';
            });

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: statusBgColors,
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.5,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }

        // Grafik Produk Terlaris
        const productCtx = document.getElementById('productChart');
        if (productCtx) {
            const productLabels = JSON.parse(productCtx.dataset.labels || '[]');
            const productData = JSON.parse(productCtx.dataset.values || '[]');
            
            new Chart(productCtx, {
                type: 'bar',
                data: {
                    labels: productLabels,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: productData,
                        backgroundColor: '#0b5c2c',
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2.5,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-admin-layout>
