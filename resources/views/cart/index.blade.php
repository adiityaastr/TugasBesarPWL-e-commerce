<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Keranjang Belanja</h1>
            
            @if($cartItems->isEmpty())
                <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">

                    <h2 class="text-xl font-bold text-gray-800 mb-2">Wah, keranjang belanjamu kosong</h2>
                    <p class="text-gray-600 mb-6">Yuk, isi dengan barang-barang impianmu!</p>
                    <a href="{{ route('home') }}" class="inline-block bg-[#0b5c2c] text-white font-bold py-3 px-8 rounded-lg hover:bg-[#09481f] transition shadow">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Cart Items -->
                    <div class="lg:flex-1">
                         <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                             <!-- Header -->
                             <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                                <input type="checkbox" id="select-all" checked class="rounded text-[#0b5c2c] focus:ring-[#0b5c2c]">
                                <label for="select-all" class="font-semibold text-gray-800 cursor-pointer">Pilih Semua</label>
                             </div>

                             @php $total = 0; @endphp
                             @foreach($cartItems as $item)
                                @php $itemTotal = $item->product->price * $item->quantity; $total += $itemTotal; @endphp
                                <div class="p-6 border-b border-gray-100 last:border-none cart-item" data-item-id="{{ $item->id }}" data-price="{{ $item->product->price }}" data-quantity="{{ $item->quantity }}">
                                    <div class="flex items-start gap-4">
                                        <input type="checkbox" class="item-checkbox mt-1 rounded text-[#0b5c2c] focus:ring-[#0b5c2c]" checked data-item-id="{{ $item->id }}">
                                        
                                        <!-- Image -->
                                        <div class="w-20 h-20 shrink-0">
                                            @if($item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover rounded-md" alt="{{ $item->product->name }}">
                                            @else
                                                <div class="w-full h-full bg-gray-100 rounded-md flex items-center justify-center text-gray-400">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Info -->
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 mb-1">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500 mb-3">{{ $item->product->description }}</p>
                                        <div class="font-bold text-[#0b5c2c]">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex justify-end items-center mt-4 gap-4">
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST" class="delete-item-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="update-quantity-form flex items-center border border-gray-200 rounded-lg bg-gray-50">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l disabled:opacity-50" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                            <input type="text" readonly value="{{ $item->quantity }}" class="item-quantity w-10 text-center border-none bg-gray-50 p-1 text-sm focus:ring-0 text-gray-900" data-item-id="{{ $item->id }}">
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-3 py-1 text-[#0b5c2c] hover:bg-gray-100 rounded-r">+</button>
                                        </form>
                                    </div>
                                </div>
                             @endforeach
                         </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="lg:w-96">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h3 class="font-bold text-lg text-gray-900 mb-6">Ringkasan Belanja</h3>
                            
                            <div class="flex justify-between items-center mb-4 text-gray-700">
                                <span>Total Harga (<span id="selected-items-count">{{ $cartItems->sum('quantity') }}</span> barang)</span>
                                <span class="font-semibold text-gray-900" id="selected-total-price">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="border-t border-gray-100 my-4"></div>
                            
                            <div class="flex justify-between items-center mb-8">
                                <span class="font-bold text-lg text-gray-900">Total Tagihan</span>
                                <span class="font-bold text-lg text-[#0b5c2c]" id="total-bill">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full bg-[#0b5c2c] hover:bg-[#09481f] text-white font-bold py-3 rounded-lg text-center shadow-lg transition transform hover:-translate-y-1">
                                Beli (<span id="checkout-items-count">{{ $cartItems->sum('quantity') }}</span>)
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const selectedTotalPriceEl = document.getElementById('selected-total-price');
            const totalBillEl = document.getElementById('total-bill');
            const selectedItemsCountEl = document.getElementById('selected-items-count');
            const checkoutItemsCountEl = document.getElementById('checkout-items-count');

            function formatRupiah(num) {
                return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function calculateTotal() {
                let total = 0;
                let totalItems = 0;

                itemCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const cartItem = checkbox.closest('.cart-item');
                        if (cartItem) {
                            const price = parseFloat(cartItem.dataset.price);
                            const quantity = parseInt(cartItem.dataset.quantity);
                            total += price * quantity;
                            totalItems += quantity;
                        }
                    }
                });

                selectedTotalPriceEl.textContent = formatRupiah(total);
                totalBillEl.textContent = formatRupiah(total);
                selectedItemsCountEl.textContent = totalItems;
                checkoutItemsCountEl.textContent = totalItems;
            }

            // Handle select all checkbox
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    calculateTotal();
                });
            }

            // Handle individual item checkboxes
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Update select all checkbox state
                    const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = allChecked;
                    }
                    calculateTotal();
                });
            });

            // Handle quantity update
            document.querySelectorAll('.update-quantity-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const clickedButton = e.submitter;
                    if (!clickedButton || clickedButton.type !== 'submit') return;
                    
                    const quantity = parseInt(clickedButton.value);
                    const itemId = this.querySelector('.item-quantity').dataset.itemId;
                    const cartItem = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                    
                    fetch(this.action, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ quantity: quantity })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update quantity in cart item
                            if (cartItem) {
                                cartItem.dataset.quantity = quantity;
                                const quantityInput = cartItem.querySelector('.item-quantity');
                                if (quantityInput) {
                                    quantityInput.value = quantity;
                                }
                                
                                // Update disabled state of buttons
                                const minusBtn = this.querySelector('button[name="quantity"][value="' + (quantity - 1) + '"]');
                                const plusBtn = this.querySelector('button[name="quantity"][value="' + (quantity + 1) + '"]');
                                
                                // Update all minus buttons
                                const allMinusBtns = this.querySelectorAll('button[name="quantity"]');
                                allMinusBtns.forEach(btn => {
                                    const btnValue = parseInt(btn.value);
                                    if (btnValue < quantity) {
                                        btn.disabled = quantity <= 1;
                                    }
                                });
                                
                                // Recalculate total
                                calculateTotal();
                                
                                // Update cart badge if function exists
                                if (typeof updateCartBadge === 'function' && data.cartCount !== undefined) {
                                    updateCartBadge(data.cartCount);
                                }
                            }
                        } else {
                            alert(data.message || 'Gagal memperbarui jumlah');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui jumlah');
                    });
                });
            });

            // Handle item deletion
            document.querySelectorAll('.delete-item-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!confirm('Hapus item dari keranjang?')) return;
                    
                    const itemId = this.closest('.cart-item').dataset.itemId;
                    const cartItem = this.closest('.cart-item');
                    
                    fetch(this.action, {
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
                            cartItem.remove();
                            
                            // Update select all checkbox
                            const remainingCheckboxes = document.querySelectorAll('.item-checkbox');
                            if (selectAllCheckbox && remainingCheckboxes.length > 0) {
                                selectAllCheckbox.checked = Array.from(remainingCheckboxes).every(cb => cb.checked);
                            }
                            
                            // Recalculate total
                            calculateTotal();
                            
                            // Update cart badge if function exists
                            if (typeof updateCartBadge === 'function' && data.cartCount !== undefined) {
                                updateCartBadge(data.cartCount);
                            }
                            
                            // If cart is empty, reload page
                            if (remainingCheckboxes.length === 0) {
                                location.reload();
                            }
                        } else {
                            alert(data.message || 'Gagal menghapus item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menghapus item');
                    });
                });
            });

            // Initial calculation
            calculateTotal();
        });
    </script>
</x-app-layout>
