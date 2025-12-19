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
                        <h2 class="text-2xl font-bold text-gray-900">Kelola Komplain</h2>
                        @php
                            $pendingComplaints = \App\Models\Complaint::where('status', 'pending')->count();
                        @endphp
                        @if($pendingComplaints > 0)
                            <div class="bg-orange-50 border border-orange-200 rounded-lg px-4 py-2">
                                <span class="text-sm font-semibold text-orange-700">
                                    ⚠️ {{ $pendingComplaints }} komplain menunggu peninjauan
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
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul Komplain</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complaints as $complaint)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm font-semibold text-gray-900">
                                            {{ $complaint->order->order_number ?? '#'.$complaint->order->id }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm text-gray-700">
                                            {{ $complaint->user->full_name ?? $complaint->user->name }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm text-gray-700">
                                            <div class="max-w-xs truncate" title="{{ $complaint->title }}">
                                                {{ $complaint->title }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm text-gray-600">
                                            {{ $complaint->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm">
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
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-100 bg-white text-sm">
                                            <a href="{{ route('admin.complaints.show', $complaint) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-[#0b5c2c] hover:bg-[#094520] rounded-lg shadow transition">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                            Belum ada komplain.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $complaints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

