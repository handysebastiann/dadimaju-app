<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 hover:underline">
                {{ __('Dashboard') }}
            </a>

            <span class="mx-2 text-gray-400">></span>

            <span class="text-gray-800 dark:text-gray-50">
                {{ __('Product') }}
            </span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between">
                    <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                    + Tambah Barang Baru
                    </a>

                    <div class="mb-4">
                        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                            
                            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" 
                                class="border rounded py-2 px-3 flex-grow shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <select name="category_id" class="border rounded py-2 pl-3 pr-8 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="stock_status" class="border rounded py-2 pl-3 pr-8 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="menipis" {{ request('stock_status') == 'menipis' ? 'selected' : '' }}>Stok Menipis (< 5)</option>
                                <option value="habis" {{ request('stock_status') == 'habis' ? 'selected' : '' }}>Stok Habis (0)</option>
                            </select>

                            <button type="submit" class="bg-gray-800 text-white py-2 px-4 rounded hover:bg-gray-700 shadow-sm transition duration-150">
                                Filter
                            </button>

                            @if(request('search') || request('category_id') || request('stock_status'))
                                <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 shadow-sm text-center flex items-center justify-center">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                
                <table class="table-auto w-full mt-4">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2">Gambar</th>
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Kategori</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Stok</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 align-middle">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Foto" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>

                            <td class="px-4 py-2 align-middle">
                                {{ $product->name }}
                            </td>

                            <td class="px-4 py-2 align-middle">
                                {{ $product->category->name ?? 'Tidak ada kategori' }}
                            </td>

                            <td class="px-4 py-2 align-middle">
                                Rp {{ number_format($product->price) }}
                            </td>

                            <td class="px-4 py-2 align-middle">
                                @if ($product->stock <= 0)
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        Habis!
                                    </span>
                                @elseif ($product->stock < 5)
                                    <div class="flex items-center gap-1">
                                        <span class="text-orange-600 font-bold">{{ $product->stock }}</span>
                                        <span class="bg-orange-100 text-orange-800 text-xs px-2 py-0.5 rounded">Menipis</span>
                                    </div>
                                @else
                                    <span class="text-green-600 font-bold">{{ $product->stock }}</span>
                                @endif
                            </td>

                            <td class="px-4 py-2 align-middle">
                                <div class="flex items-center gap-2">
                                    
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 font-medium">
                                        Edit
                                    </a>
                                    
                                    <span class="text-gray-300">|</span> 

                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" onclick="confirmDelete({{ $product->id }})" class="text-red-500 hover:text-red-700 font-medium">
                                        Hapus
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>