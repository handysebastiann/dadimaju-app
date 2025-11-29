<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                            <div class="text-2xl font-bold">{{ $total_products }}</div>
                            <div class="text-sm uppercase tracking-wide">Jenis Barang</div>
                        </div>

                        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
                            <div class="text-2xl font-bold">{{ $total_stock }}</div>
                            <div class="text-sm uppercase tracking-wide">Total Stok Tersedia</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 items-start">

                        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-l-8 border-red-500">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-red-600">⚠️ Stok Habis</h3>
                                    <a href="{{ route('products.index', ['stock_status' => 'habis']) }}" class="text-sm text-blue-500 hover:underline">Lihat Semua &rarr;</a>
                                </div>

                                @if($products_habis->isEmpty())
                                    <p class="text-gray-500 italic text-sm">Aman, tidak ada barang habis.</p>
                                @else
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($products_habis as $item)
                                        <li class="py-3 flex justify-between items-center">
                                            <span class="text-gray-700 font-medium">{{ $item->name }}</span>
                                            <a href="{{ route('products.edit', $item->id) }}" class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs hover:bg-red-200">
                                                Restock
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-l-8 border-orange-300">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-orange-400">⚡ Stok Menipis</h3>
                                    <a href="{{ route('products.index', ['stock_status' => 'menipis']) }}" class="text-sm text-blue-500 hover:underline">Lihat Semua &rarr;</a>
                                </div>

                                @if($products_menipis->isEmpty())
                                    <p class="text-gray-500 italic text-sm">Stok aman terkendali.</p>
                                @else
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($products_menipis as $item)
                                        <li class="py-3 flex justify-between items-center">
                                            <div>
                                                <span class="text-gray-700 font-medium block">{{ $item->name }}</span>
                                                <span class="text-xs text-orange-500">Sisa: {{ $item->stock }}</span>
                                            </div>
                                            <a href="{{ route('products.edit', $item->id) }}" class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs hover:bg-orange-200">
                                                Tambah
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="mt-8">
                        <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">
                            &rarr; Kelola Data Barang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
