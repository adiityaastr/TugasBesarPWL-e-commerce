<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Pengiriman</h1>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left: Shipping & Payment -->
                    <div class="lg:flex-1 space-y-6">
                        <!-- Address Section -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#0b5c2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Alamat Pengiriman
                            </h2>

                            <!-- Saved Addresses -->
                            @if($addresses->count() > 0)
                                <div class="mb-6">
                                    <label class="block text-gray-800 text-sm font-semibold mb-3">Pilih Alamat Tersimpan</label>
                                    <div class="space-y-3" id="saved-addresses">
                                        @foreach($addresses as $address)
                                            <div class="address-item" data-address-id="{{ $address->id }}">
                                                <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#0b5c2c] hover:bg-green-50 transition address-option" data-address-id="{{ $address->id }}">
                                                    <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1 h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300 address-radio" @if($address->is_default) checked @endif>
                                                    <div class="ml-3 flex-1">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="font-bold text-gray-900">{{ $address->recipient_name }}</span>
                                                            <div class="flex items-center gap-2">
                                                                @if($address->is_default)
                                                                    <span class="text-xs bg-[#0b5c2c] text-white px-2 py-1 rounded">Default</span>
                                                                @endif
                                                                <button type="button" onclick="openEditAddressForm({{ $address->id }})" class="text-xs text-[#0b5c2c] hover:text-[#09481f] font-semibold px-2 py-1 rounded hover:bg-green-100 transition">
                                                                    Edit
                                                                </button>
                                                                <button type="button" onclick="deleteAddress({{ $address->id }})" class="text-xs text-red-600 hover:text-red-700 font-semibold px-2 py-1 rounded hover:bg-red-50 transition">
                                                                    Hapus
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm text-gray-700 mb-1">{{ $address->shipping_address }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            @if($address->kelurahan){{ $address->kelurahan }}, @endif
                                                            @if($address->kecamatan){{ $address->kecamatan }}, @endif
                                                            @if($address->kota){{ $address->kota }}, @endif
                                                            @if($address->provinsi){{ $address->provinsi }} @endif
                                                            @if($address->kode_pos){{ $address->kode_pos }}@endif
                                                        </p>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="address_id" value="" class="h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300 address-radio" id="use-new-address">
                                            <span class="ml-2 text-sm text-gray-700">Gunakan alamat baru</span>
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <!-- New Address Form -->
                            <div id="new-address-form" class="@if($addresses->count() > 0) hidden @endif">
                                <div class="mb-4">
                                    <label for="recipient_name" class="block text-gray-800 text-sm font-semibold mb-2">Nama Penerima</label>
                                    <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name', Auth::user()->name) }}" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" placeholder="Nama penerima" @if($addresses->count() == 0) required @endif>
                                </div>

                                <div class="mb-3">
                                    <label for="shipping_address" class="block text-gray-800 text-sm font-semibold mb-2">Alamat Lengkap</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" placeholder="Nama jalan, nomor rumah, RT/RW" @if($addresses->count() == 0) required @endif></textarea>
                                </div>
                                @php
                                    // Placeholder sample; ganti dengan data master wilayah lengkap Indonesia bila tersedia.
                                    $provinsiOptions = ['DKI Jakarta','Jawa Barat','Jawa Tengah','DI Yogyakarta','Jawa Timur'];
                                    $kotaOptions = ['Jakarta Selatan','Jakarta Barat','Bandung','Semarang','Surabaya'];
                                    $kecamatanOptions = ['Setiabudi','Kebon Jeruk','Coblong','Banyumanik','Wonokromo'];
                                    $kelurahanOptions = ['Kuningan','Duri Kepa','Dago','Padangsari','Darmo'];
                                    $kodeposOptions = ['12920','11510','40135','50263','60241'];
                                @endphp
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-gray-800 text-sm font-semibold mb-2">Provinsi</label>
                                        <select id="provinsi" name="provinsi" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900">
                                            <option value="">Pilih provinsi</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-gray-800 text-sm font-semibold mb-2">Kota/Kabupaten</label>
                                        <select id="kota" name="kota" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" disabled>
                                            <option value="">Pilih kota/kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-gray-800 text-sm font-semibold mb-2">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" disabled>
                                            <option value="">Pilih kecamatan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-gray-800 text-sm font-semibold mb-2">Kelurahan</label>
                                        <select id="kelurahan" name="kelurahan" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" disabled>
                                            <option value="">Pilih kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-gray-800 text-sm font-semibold mb-2">Kode Pos</label>
                                        <input id="kode_pos" type="text" name="kode_pos" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" placeholder="Isi kode pos">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="save_address" value="1" class="h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Simpan alamat ini untuk pembelian selanjutnya</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Options -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#0b5c2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Pilih Pengiriman
                            </h2>
                            <div class="space-y-3">
                                @php
                                    $shippingOptions = [
                                        ['label' => 'Reguler (2-3 hari)', 'value' => 'reguler', 'price' => 15000],
                                        ['label' => 'Kargo (3-5 hari)', 'value' => 'kargo', 'price' => 10000],
                                        ['label' => 'Same Day (hari ini)', 'value' => 'same_day', 'price' => 30000],
                                    ];
                                @endphp
                                @foreach($shippingOptions as $opt)
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[#0b5c2c] hover:bg-green-50 transition" data-price="{{ $opt['price'] }}">
                                        <input type="radio" name="shipping_method" value="{{ $opt['value'] }}" class="h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300" @checked($loop->first)>
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-900">{{ $opt['label'] }}</span>
                                            <span class="block text-xs text-gray-500">Rp{{ number_format($opt['price'], 0, ',', '.') }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                         <!-- Payment Method -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#0b5c2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Pilih Pembayaran
                            </h2>

                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[#0b5c2c] hover:bg-green-50 transition">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300" checked>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-900">Transfer Virtual Account</span>
                                        <span class="block text-xs text-gray-500">BCA, Mandiri, BNI, BRI</span>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[#0b5c2c] hover:bg-green-50 transition">
                                    <input type="radio" name="payment_method" value="credit_card" class="h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300">
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-900">Kartu Kredit / Debit Online</span>
                                        <span class="block text-xs text-gray-500">Visa, Mastercard, JCB</span>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[#0b5c2c] hover:bg-green-50 transition">
                                    <input type="radio" name="payment_method" value="cod" class="h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300">
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
                            
                            @php $total = 0; $shippingDefault = 15000; @endphp
                            <div class="space-y-3 mb-4 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                @foreach($cartItems as $item)
                                    @php $total += $item->product->price * $item->quantity; @endphp
                                    <div class="flex items-center gap-3 text-sm">
                                        <div class="w-14 h-14 rounded-md bg-gray-100 border overflow-hidden shrink-0">
                                            @if($item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover" alt="{{ $item->product->name }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">IMG</div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-gray-800 font-semibold truncate">{{ $item->product->name }}</div>
                                            <div class="text-gray-500">Qty: {{ $item->quantity }}x</div>
                                        </div>
                                        <div class="font-semibold text-gray-900 text-right">
                                            Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-100 my-4 pt-4 space-y-2">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Total Harga</span>
                                    <span id="total-harga" class="font-bold text-gray-900">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Ongkos Kirim (estimasi)</span>
                                    <span id="total-ongkir" class="text-[#0b5c2c] font-semibold">Rp{{ number_format($shippingDefault, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <span class="font-bold text-lg text-gray-900">Perkiraan Total</span>
                                    <span id="total-tagihan" class="font-bold text-xl text-[#0b5c2c]">Rp{{ number_format($total + $shippingDefault, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-[#0b5c2c] hover:bg-[#09481f] text-white font-bold py-3 px-4 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
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

    <!-- Address Edit Success Notification Modal -->
    <div id="address-edit-success-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="address-edit-success-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeAddressEditSuccessModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center justify-center mb-4">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2" id="address-edit-success-title">
                            Alamat Berhasil Diperbarui!
                        </h3>
                        <p class="text-sm text-gray-600 mb-6" id="address-edit-success-message">
                            Perubahan alamat telah disimpan.
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-center border-t border-gray-200">
                    <button onclick="closeAddressEditSuccessModal()" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-[#0b5c2c] text-base font-medium text-white hover:bg-[#09481f] transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Delete Confirmation Modal -->
    <div id="address-delete-confirm-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="address-delete-confirm-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeAddressDeleteConfirmModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center justify-center mb-4">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2" id="address-delete-confirm-title">
                            Hapus Alamat?
                        </h3>
                        <p class="text-sm text-gray-600 mb-6">
                            Apakah Anda yakin ingin menghapus alamat ini? Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row gap-3 border-t border-gray-200">
                    <button onclick="closeAddressDeleteConfirmModal()" class="flex-1 inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button id="confirm-delete-address-btn" onclick="confirmDeleteAddress()" class="flex-1 inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 transition">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Delete Success Notification Modal -->
    <div id="address-delete-success-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="address-delete-success-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeAddressDeleteSuccessModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center justify-center mb-4">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2" id="address-delete-success-title">
                            Alamat Berhasil Dihapus!
                        </h3>
                        <p class="text-sm text-gray-600 mb-6" id="address-delete-success-message">
                            Alamat telah dihapus dari daftar alamat Anda.
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-center border-t border-gray-200">
                    <button onclick="closeAddressDeleteSuccessModal()" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-[#0b5c2c] text-base font-medium text-white hover:bg-[#09481f] transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Address Forms (Outside main form to avoid nesting) -->
    @if($addresses->count() > 0)
        @foreach($addresses as $address)
            <div id="edit-address-form-{{ $address->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="edit-address-title-{{ $address->id }}" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeEditAddressForm({{ $address->id }})"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900" id="edit-address-title-{{ $address->id }}">Edit Alamat</h3>
                                <button type="button" onclick="closeEditAddressForm({{ $address->id }})" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <form class="edit-address-form" data-address-id="{{ $address->id }}" action="{{ route('addresses.update', $address) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-800 mb-1">Nama Penerima</label>
                                        <input type="text" name="recipient_name" value="{{ $address->recipient_name }}" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-800 mb-1">Alamat Lengkap</label>
                                        <textarea name="shipping_address" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" required>{{ $address->shipping_address }}</textarea>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-800 mb-1">Provinsi</label>
                                            <input type="text" name="provinsi" value="{{ $address->provinsi }}" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-800 mb-1">Kota/Kabupaten</label>
                                            <input type="text" name="kota" value="{{ $address->kota }}" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-800 mb-1">Kecamatan</label>
                                            <input type="text" name="kecamatan" value="{{ $address->kecamatan }}" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-800 mb-1">Kelurahan</label>
                                            <input type="text" name="kelurahan" value="{{ $address->kelurahan }}" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-800 mb-1">Kode Pos</label>
                                        <input type="text" name="kode_pos" value="{{ $address->kode_pos }}" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="is_default" value="1" id="is_default_{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }} class="h-4 w-4 text-[#0b5c2c] focus:ring-[#0b5c2c] border-gray-300 rounded">
                                        <label for="is_default_{{ $address->id }}" class="text-sm text-gray-700">Jadikan sebagai alamat default</label>
                                    </div>
                                    <div class="flex items-center gap-2 pt-2">
                                        <button type="submit" class="px-4 py-2 bg-[#0b5c2c] hover:bg-[#09481f] text-white text-sm font-semibold rounded-lg transition">
                                            Simpan Perubahan
                                        </button>
                                        <button type="button" onclick="closeEditAddressForm({{ $address->id }})" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <script>
        const baseTotal = Number(@json($total));
        let shippingPrice = 15000; // default reguler

        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const totalHargaEl = document.getElementById('total-harga');
        const totalOngkirEl = document.getElementById('total-ongkir');
        const totalTagihanEl = document.getElementById('total-tagihan');

        // Address toggle functionality
        const addressRadios = document.querySelectorAll('input[name="address_id"].address-radio');
        const newAddressForm = document.getElementById('new-address-form');
        const newAddressInputs = newAddressForm ? newAddressForm.querySelectorAll('input[required], textarea[required], select[required]') : [];

        function toggleAddressForm() {
            const selectedAddress = document.querySelector('input[name="address_id"]:checked');
            
            if (selectedAddress && selectedAddress.value !== '') {
                // Use saved address - hide and disable new address form
                if (newAddressForm) {
                    newAddressForm.classList.add('hidden');
                    newAddressInputs.forEach(input => {
                        input.removeAttribute('required');
                        input.disabled = true;
                    });
                }
            } else {
                // Use new address - show and enable new address form
                if (newAddressForm) {
                    newAddressForm.classList.remove('hidden');
                    newAddressInputs.forEach(input => {
                        input.setAttribute('required', 'required');
                        input.disabled = false;
                    });
                }
            }
        }

        // Add event listeners for address selection
        addressRadios.forEach(radio => {
            radio.addEventListener('change', toggleAddressForm);
        });

        // Initialize on page load
        if (addressRadios.length > 0) {
            toggleAddressForm();
        }

        // Edit Address Functions
        function openEditAddressForm(addressId) {
            const modal = document.getElementById(`edit-address-form-${addressId}`);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }

        function closeEditAddressForm(addressId) {
            const modal = document.getElementById(`edit-address-form-${addressId}`);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            }
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                // Close edit address modals
                document.querySelectorAll('[id^="edit-address-form-"]').forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        const addressId = modal.id.replace('edit-address-form-', '');
                        closeEditAddressForm(addressId);
                    }
                });
                // Close success notification modals
                closeAddressEditSuccessModal();
                closeAddressDeleteSuccessModal();
                // Close delete confirmation modal
                closeAddressDeleteConfirmModal();
            }
        });

        // Address Edit Success Notification Functions
        function showAddressEditSuccessModal(message) {
            const modal = document.getElementById('address-edit-success-modal');
            const messageEl = document.getElementById('address-edit-success-message');
            if (modal && messageEl) {
                messageEl.textContent = message;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }

        function closeAddressEditSuccessModal() {
            const modal = document.getElementById('address-edit-success-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
                // Reload page after closing to update the address list
                setTimeout(() => {
                    location.reload();
                }, 300);
            }
        }

        // Handle edit address form submission
        document.querySelectorAll('.edit-address-form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const addressId = this.dataset.addressId;
                const formData = new FormData(this);
                
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    if (response.ok) {
                        const data = await response.json();
                        // Close edit modal
                        closeEditAddressForm(addressId);
                        // Show success notification
                        showAddressEditSuccessModal(data.message || 'Alamat berhasil diperbarui');
                    } else {
                        const error = await response.json().catch(() => ({ message: 'Gagal memperbarui alamat' }));
                        alert(error.message || 'Gagal memperbarui alamat');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Gagal memperbarui alamat');
                }
            });
        });

        // Delete Address Function
        let pendingDeleteAddressId = null;

        window.deleteAddress = function(addressId) {
            pendingDeleteAddressId = addressId;
            showAddressDeleteConfirmModal();
        };

        function showAddressDeleteConfirmModal() {
            const modal = document.getElementById('address-delete-confirm-modal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }

        function closeAddressDeleteConfirmModal() {
            const modal = document.getElementById('address-delete-confirm-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
                pendingDeleteAddressId = null;
            }
        }

        function confirmDeleteAddress() {
            if (!pendingDeleteAddressId) return;

            const addressId = pendingDeleteAddressId;
            closeAddressDeleteConfirmModal();

            fetch(`/addresses/${addressId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove address item from DOM
                    const addressItem = document.querySelector(`.address-item[data-address-id="${addressId}"]`);
                    if (addressItem) {
                        addressItem.remove();
                    }

                    // If no addresses left, show new address form
                    const remainingAddresses = document.querySelectorAll('.address-item');
                    if (remainingAddresses.length === 0) {
                        const newAddressForm = document.getElementById('new-address-form');
                        if (newAddressForm) {
                            newAddressForm.classList.remove('hidden');
                            const newAddressInputs = newAddressForm.querySelectorAll('input[required], textarea[required], select[required]');
                            newAddressInputs.forEach(input => {
                                input.setAttribute('required', 'required');
                                input.disabled = false;
                            });
                        }
                        // Uncheck "use new address" radio if exists
                        const useNewAddressRadio = document.getElementById('use-new-address');
                        if (useNewAddressRadio) {
                            useNewAddressRadio.checked = true;
                        }
                    }

                    // Show success notification
                    showAddressDeleteSuccessModal(data.message || 'Alamat berhasil dihapus');
                } else {
                    alert(data.message || 'Gagal menghapus alamat');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus alamat');
            });
        }

        function showAddressDeleteSuccessModal(message) {
            const modal = document.getElementById('address-delete-success-modal');
            const messageEl = document.getElementById('address-delete-success-message');
            if (modal && messageEl) {
                messageEl.textContent = message;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }

        function closeAddressDeleteSuccessModal() {
            const modal = document.getElementById('address-delete-success-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            }
        }

        function formatRupiah(num) {
            return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateSummary() {
            if (totalHargaEl && totalOngkirEl && totalTagihanEl) {
                totalHargaEl.textContent = formatRupiah(baseTotal);
                totalOngkirEl.textContent = formatRupiah(shippingPrice);
                totalTagihanEl.textContent = formatRupiah(baseTotal + shippingPrice);
            }
        }

        shippingRadios.forEach(r => {
            r.addEventListener('change', () => {
                const price = Number(r.closest('label')?.dataset.price || 15000);
                shippingPrice = price;
                updateSummary();
            });
        });

        // set initial shipping price from first radio
        const firstShipping = document.querySelector('label[data-price]')?.dataset.price;
        if (firstShipping) {
            shippingPrice = Number(firstShipping);
        }
        updateSummary();

        // Wilayah dropdowns
        const provEl = document.getElementById('provinsi');
        const kotaEl = document.getElementById('kota');
        const kecEl = document.getElementById('kecamatan');
        const kelEl = document.getElementById('kelurahan');

        // Track status API per field
        const fieldStatus = {
            provinsi: false, // false = belum loaded/gagal, true = berhasil
            kota: false,
            kecamatan: false,
            kelurahan: false
        };

        async function fetchWithTimeout(url, timeout = 10000) {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), timeout);
            try {
                const res = await fetch(url, { signal: controller.signal });
                clearTimeout(timeoutId);
                return res;
            } catch (e) {
                clearTimeout(timeoutId);
                throw e;
            }
        }

        function updateErrorMessage() {
            const errorMsg = document.getElementById('api-error-message');
            if (!errorMsg) return;
            
            // Cek apakah ada field yang gagal
            const hasFailedFields = Object.values(fieldStatus).some(status => status === false);
            
            if (hasFailedFields) {
                errorMsg.classList.remove('hidden');
            } else {
                errorMsg.classList.add('hidden');
            }
        }

        function convertSelectToInput(selectEl, fieldName) {
            if (selectEl.tagName !== 'SELECT') return selectEl;
            
            // Simpan nilai yang sudah dipilih jika ada
            const currentValue = selectEl.value || '';
            const placeholder = selectEl.options[0]?.textContent || 'Isi manual';
            
            // Buat input text baru
            const inputEl = document.createElement('input');
            inputEl.type = 'text';
            inputEl.id = selectEl.id;
            inputEl.name = selectEl.name;
            inputEl.placeholder = placeholder;
            inputEl.value = currentValue;
            inputEl.classList.add('w-full', 'border-gray-300', 'rounded-lg', 'focus:ring-[#0b5c2c]', 'focus:border-[#0b5c2c]', 'text-gray-900');
            
            // Ganti select dengan input
            selectEl.parentNode.replaceChild(inputEl, selectEl);
            
            return inputEl;
        }

        async function fetchAndFill(url, selectEl, placeholder, fieldName) {
            selectEl.innerHTML = `<option value="">${placeholder}</option>`;
            selectEl.disabled = true;
            try {
                const res = await fetchWithTimeout(url, 10000);
                if (!res.ok) throw new Error('Network');
                const json = await res.json();
                const data = json.data || json || [];
                if (data.length === 0) throw new Error('Empty data');
                data.forEach(item => {
                    const opt = document.createElement('option');
                    // API emsifa: id + name
                    const val = item.name || item.nama || '';
                    const code = item.id || item.code || item.kode || '';
                    opt.value = val;
                    opt.textContent = val;
                    opt.dataset.code = code;
                    selectEl.appendChild(opt);
                });
                selectEl.disabled = false;
                selectEl.removeAttribute('required');
                // Update status field sebagai berhasil
                if (fieldName) {
                    fieldStatus[fieldName] = true;
                }
                updateErrorMessage();
            } catch (e) {
                // Convert select ke input text agar user bisa input manual
                let finalEl = selectEl;
                if (fieldName && selectEl.tagName === 'SELECT') {
                    finalEl = convertSelectToInput(selectEl, fieldName);
                } else if (selectEl.tagName === 'SELECT') {
                    selectEl.innerHTML = `<option value="">Gagal memuat</option>`;
                    selectEl.disabled = true;
                }
                finalEl.removeAttribute('required');
                // Update status field sebagai gagal
                if (fieldName) {
                    fieldStatus[fieldName] = false;
                }
                updateErrorMessage();
            }
        }

        function resetSelect(selectEl, placeholder) {
            if (!selectEl || selectEl.tagName !== 'SELECT') return;
            selectEl.innerHTML = `<option value="">${placeholder}</option>`;
            selectEl.disabled = true;
        }

        const wilayahBase = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        document.addEventListener('DOMContentLoaded', () => {
            updateSummary();
            fetchAndFill(`${wilayahBase}/provinces.json`, provEl, 'Pilih provinsi', 'provinsi');
        });

        // Event listener dengan delegasi untuk handle perubahan elemen (select atau input)
        document.addEventListener('change', (e) => {
            if (e.target.id === 'provinsi') {
                const provinsiEl = document.getElementById('provinsi');
                let code = null;
                if (provinsiEl.tagName === 'SELECT') {
                    code = provinsiEl.selectedOptions[0]?.dataset.code;
                }
                // Reset child fields
                const kotaElNew = document.getElementById('kota');
                const kecElNew = document.getElementById('kecamatan');
                const kelElNew = document.getElementById('kelurahan');
                if (kotaElNew && kotaElNew.tagName === 'SELECT') {
                    resetSelect(kotaElNew, 'Pilih kota/kabupaten');
                }
                if (kecElNew && kecElNew.tagName === 'SELECT') {
                    resetSelect(kecElNew, 'Pilih kecamatan');
                }
                if (kelElNew && kelElNew.tagName === 'SELECT') {
                    resetSelect(kelElNew, 'Pilih kelurahan');
                }
                fieldStatus.kota = false;
                fieldStatus.kecamatan = false;
                fieldStatus.kelurahan = false;
                updateErrorMessage();
                if (code && kotaElNew && kotaElNew.tagName === 'SELECT') {
                    fetchAndFill(`${wilayahBase}/regencies/${code}.json`, kotaElNew, 'Pilih kota/kabupaten', 'kota');
                }
            } else if (e.target.id === 'kota') {
                const kotaElNew = document.getElementById('kota');
                let code = null;
                if (kotaElNew && kotaElNew.tagName === 'SELECT') {
                    code = kotaElNew.selectedOptions[0]?.dataset.code;
                }
                // Reset child fields
                const kecElNew = document.getElementById('kecamatan');
                const kelElNew = document.getElementById('kelurahan');
                if (kecElNew && kecElNew.tagName === 'SELECT') {
                    resetSelect(kecElNew, 'Pilih kecamatan');
                }
                if (kelElNew && kelElNew.tagName === 'SELECT') {
                    resetSelect(kelElNew, 'Pilih kelurahan');
                }
                fieldStatus.kecamatan = false;
                fieldStatus.kelurahan = false;
                updateErrorMessage();
                if (code && kecElNew && kecElNew.tagName === 'SELECT') {
                    fetchAndFill(`${wilayahBase}/districts/${code}.json`, kecElNew, 'Pilih kecamatan', 'kecamatan');
                }
            } else if (e.target.id === 'kecamatan') {
                const kecElNew = document.getElementById('kecamatan');
                let code = null;
                if (kecElNew && kecElNew.tagName === 'SELECT') {
                    code = kecElNew.selectedOptions[0]?.dataset.code;
                }
                // Reset child field
                const kelElNew = document.getElementById('kelurahan');
                if (kelElNew && kelElNew.tagName === 'SELECT') {
                    resetSelect(kelElNew, 'Pilih kelurahan');
                }
                fieldStatus.kelurahan = false;
                updateErrorMessage();
                if (code && kelElNew && kelElNew.tagName === 'SELECT') {
                    fetchAndFill(`${wilayahBase}/villages/${code}.json`, kelElNew, 'Pilih kelurahan', 'kelurahan');
                }
            }
        });
    </script>
</x-app-layout>
