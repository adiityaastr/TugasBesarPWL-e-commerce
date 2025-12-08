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
                            
                            <div class="mb-4">
                                <label class="block text-gray-800 text-sm font-semibold mb-2">Nama Penerima</label>
                                <div class="p-3 bg-white border border-gray-200 rounded-lg text-gray-900 font-semibold">
                                    {{ Auth::user()->name }} <span class="text-gray-500 font-normal">({{ Auth::user()->email }})</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="block text-gray-800 text-sm font-semibold mb-2">Alamat Lengkap</label>
                                <textarea id="shipping_address" name="shipping_address" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" placeholder="Nama jalan, nomor rumah, RT/RW" required></textarea>
                            </div>
                            @php
                                // Placeholder sample; ganti dengan data master wilayah lengkap Indonesia bila tersedia.
                                $provinsiOptions = ['DKI Jakarta','Jawa Barat','Jawa Tengah','DI Yogyakarta','Jawa Timur'];
                                $kotaOptions = ['Jakarta Selatan','Jakarta Barat','Bandung','Semarang','Surabaya'];
                                $kecamatanOptions = ['Setiabudi','Kebon Jeruk','Coblong','Banyumanik','Wonokromo'];
                                $kelurahanOptions = ['Kuningan','Duri Kepa','Dago','Padangsari','Darmo'];
                                $kodeposOptions = ['12920','11510','40135','50263','60241'];
                            @endphp
                            <div id="api-error-message" class="hidden mb-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    <strong>Peringatan:</strong> Data wilayah tidak dapat dimuat. Silakan isi alamat secara manual di kolom "Alamat Lengkap" di atas.
                                </p>
                            </div>
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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-800 text-sm font-semibold mb-2">Kode Pos</label>
                                    <input id="kode_pos" type="text" name="kode_pos" class="w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c] text-gray-900" placeholder="Isi kode pos">
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

    <script>
        const baseTotal = Number(@json($total));
        let shippingPrice = 15000; // default reguler

        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const totalHargaEl = document.getElementById('total-harga');
        const totalOngkirEl = document.getElementById('total-ongkir');
        const totalTagihanEl = document.getElementById('total-tagihan');

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
