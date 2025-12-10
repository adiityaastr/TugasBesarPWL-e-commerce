<x-admin-layout>
    <div class="py-10 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ isset($product) ? 'Perbarui informasi produk di bawah ini.' : 'Isi informasi di bawah untuk menambahkan produk baru.' }}
                        </p>
                    </div>

                    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif

                        <!-- Product Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">
                                Nama Produk
                            </label>
                            <input 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#0b5c2c] focus:ring focus:ring-[#0b5c2c] focus:ring-opacity-20 transition duration-200" 
                                id="name" 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $product->name ?? '') }}" 
                                placeholder="Masukkan nama produk"
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="description">
                                Deskripsi
                            </label>
                            <textarea 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#0b5c2c] focus:ring focus:ring-[#0b5c2c] focus:ring-opacity-20 transition duration-200" 
                                id="description" 
                                name="description" 
                                rows="5" 
                                placeholder="Jelaskan detail produk..."
                                required>{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="category">
                                Kategori
                            </label>
                            <div class="relative">
                                <select 
                                    id="category" 
                                    name="category" 
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#0b5c2c] focus:ring focus:ring-[#0b5c2c] focus:ring-opacity-20 transition duration-200 appearance-none"
                                >
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            @error('category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="price">
                                    Harga (Rp)
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input 
                                        class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-[#0b5c2c] focus:ring focus:ring-[#0b5c2c] focus:ring-opacity-20 transition duration-200" 
                                        id="price" 
                                        type="number" 
                                        step="0.01" 
                                        name="price" 
                                        value="{{ old('price', $product->price ?? '') }}" 
                                        placeholder="0"
                                        required
                                    >
                                </div>
                                @error('price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="stock">
                                    Stok
                                </label>
                                <input 
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#0b5c2c] focus:ring focus:ring-[#0b5c2c] focus:ring-opacity-20 transition duration-200" 
                                    id="stock" 
                                    type="number" 
                                    name="stock" 
                                    value="{{ old('stock', $product->stock ?? '') }}" 
                                    placeholder="Jumlah stok"
                                    required
                                >
                                @error('stock')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="image">
                                Gambar Produk
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#0b5c2c] transition duration-200 group">
                                <div class="space-y-1 text-center">
                                    @if(isset($product) && $product->image)
                                        <div class="mb-4">
                                            <img src="{{ Storage::url($product->image) }}" alt="Current Image" class="mx-auto h-32 object-cover rounded-lg shadow-sm">
                                            <p class="text-xs text-gray-500 mt-2">Gambar saat ini</p>
                                        </div>
                                    @else
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#0b5c2c] transition duration-200" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    @endif
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0b5c2c] hover:text-[#09481f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0b5c2c]">
                                            <span>Upload file</span>
                                            <input id="image" name="image" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, GIF up to 2MB
                                    </p>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0b5c2c] transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-[#0b5c2c] border border-transparent rounded-lg text-sm font-medium text-white hover:bg-[#09481f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0b5c2c] shadow-sm transition">
                                {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
