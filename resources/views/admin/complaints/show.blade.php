<x-admin-layout>
    <div class="py-10 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Detail Komplain</h2>
                            <p class="text-sm text-gray-600 mt-1">Order: {{ $complaint->order->order_number ?? '#'.$complaint->order->id }}</p>
                        </div>
                        <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            ← Kembali
                        </a>
                    </div>

                    <div class="space-y-6">
                        <!-- Complaint Info -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $complaint->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Diajukan oleh: {{ $complaint->user->full_name ?? $complaint->user->name }} ({{ $complaint->user->email }})</p>
                                    <p class="text-sm text-gray-500">Tanggal: {{ $complaint->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($complaint->status == 'pending') bg-orange-100 text-orange-800 
                                    @elseif($complaint->status == 'in_progress') bg-blue-100 text-blue-800 
                                    @elseif($complaint->status == 'resolved') bg-green-100 text-green-800 
                                    @elseif($complaint->status == 'rejected') bg-red-100 text-red-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    @if($complaint->status == 'pending')
                                        Menunggu
                                    @elseif($complaint->status == 'in_progress')
                                        Sedang Diproses
                                    @elseif($complaint->status == 'resolved')
                                        Selesai
                                    @elseif($complaint->status == 'rejected')
                                        Ditolak
                                    @else
                                        {{ ucfirst($complaint->status) }}
                                    @endif
                                </span>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Detail Komplain</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700 whitespace-pre-wrap">
                                    {{ $complaint->detail }}
                                </div>
                            </div>

                            @if($complaint->image_path)
                                <div class="mt-4">
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">Foto Bukti</label>
                                    <div class="border border-gray-200 rounded-lg p-2 inline-block">
                                        <img src="{{ Storage::url($complaint->image_path) }}" alt="Bukti komplain" class="max-w-md h-auto rounded-lg cursor-pointer hover:opacity-90 transition" onclick="window.open(this.src, '_blank')">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Order Info -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pesanan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Order ID:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $complaint->order->order_number ?? '#'.$complaint->order->id }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Total:</span>
                                    <span class="font-semibold text-gray-900 ml-2">Rp{{ number_format($complaint->order->total_price, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Status Pesanan:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ ucfirst($complaint->order->status) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Tanggal Pesanan:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $complaint->order->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="text-sm font-semibold text-gray-800 mb-2">Produk yang Dipesan:</h4>
                                <div class="space-y-2">
                                    @foreach($complaint->order->items as $item)
                                        <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-lg p-3">
                                            <div class="w-12 h-12 bg-white rounded-lg overflow-hidden shrink-0 border border-gray-200">
                                                @if($item->product->image)
                                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->product->name }}</div>
                                                <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}x</div>
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900">
                                                Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Admin Response -->
                        @if($complaint->admin_response)
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Tanggapan Admin</h3>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-gray-700 whitespace-pre-wrap">
                                    {{ $complaint->admin_response }}
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Diperbarui: {{ $complaint->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        @endif

                        <!-- Update Status Form -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Update Status Komplain</h3>
                            <form action="{{ route('admin.complaints.update-status', $complaint) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">Status</label>
                                    <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900">
                                        <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                        <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggapan Admin (Opsional)</label>
                                    <textarea name="admin_response" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" placeholder="Berikan tanggapan atau penjelasan untuk komplain ini...">{{ old('admin_response', $complaint->admin_response) }}</textarea>
                                </div>

                                <div class="flex items-center gap-3">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#0b5c2c] hover:bg-[#094520] text-white text-sm font-semibold rounded-lg shadow transition">
                                        Update Status
                                    </button>
                                    <a href="{{ route('admin.orders.index') }}?search={{ $complaint->order->order_number ?? $complaint->order->id }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-semibold text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                        Lihat Pesanan
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

