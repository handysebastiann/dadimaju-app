<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    // halaman daftar barang
    public function index(Request $request)
    {
        $products = Product::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })->paginate(5);

        return view('products.index', compact('products'));
    }

    // halaman form tambah barang
    public function create()
    {
        return view('products.create');
    }

    // simpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ], [
            // massage validate
            'name.required' => 'Nama barang wajib diisi!',
            'price.required' => 'Harga tidak boleh kosong!',
            'price.numeric' => 'Harga harus berupa angka!',
            'stock.required' => 'Stok harus diisi!',
            'stock.numeric' => 'Stok harus berupa angka!'
        ]);

        Product::create($request->all());
        Alert::success('Success', 'Barang berhasil disimpan!');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // halaman form edit
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // update data
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ],[
            // massage validate
            'name.required' => 'Nama barang wajib diisi!',
            'price.required' => 'Harga tidak boleh kosong!',
            'price.numeric' => 'Harga harus berupa angka!',
            'stock.required' => 'Stok harus diisi!',
            'stock.numeric' => 'Stok harus berupa angka!'
        ]);

        $product->update($request->all());
        Alert::success('Success', 'Data berhasi diupdate!');
        return redirect()->route('products.index');
    }

    // delete data
    public function destroy(Product $product)
    {
        $product->delete();
        Alert::success('Success', 'Barang dihapus!');
        return redirect()->route('products.index');
    }
}
