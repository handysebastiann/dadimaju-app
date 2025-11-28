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
                        <form action="{{ route('products.index') }}" method="GET">
                            <input type="text" name="search" placeholder="Cari barang..." class="border rounded py-2 px-3" value="{{ request('search') }}">
                            <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-700">Cari</button>
                        </form>
                    </div>
                </div>
                
                <table class="table-auto w-full mt-4">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Stok</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($product->price) }}</td>
                            <td class="px-4 py-2">{{ $product->stock }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                | 
                                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button type="button" onclick="confirmDelete({{ $product->id }})" class="text-red-500 hover:text-red-700">
                                    Hapus
                                </button>
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