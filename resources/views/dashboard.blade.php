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
