<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    // halaman daftar barang
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::with('category') // Eager loading
        ->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->when($request->category_id, function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        })
        ->when($request->stock_status, function($query) use ($request) {
            if ($request->stock_status == 'habis') {
                $query->where('stock', '<=', 0);
            } elseif ($request->stock_status == 'menipis') {
                $query->where('stock', '>', 0)->where('stock', '<', 5);
            }
        })
        ->latest() // urut terbaru
        ->paginate(5);

        return view('products.index', compact('products', 'categories'));
    }

    // halaman form tambah barang
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // simpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required',
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

        $input = $request->all();

        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('products', 'public');
            $input['image'] = $imagePath;
        }

        Product::create($input);
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
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // update data
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required',
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

        $input = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');

            $input['image'] = $imagePath;
        } else {
            unset($input['input']);
        }

        $product->update($input);
        Alert::success('Success', 'Data berhasi diupdate!');
        return redirect()->route('products.index');
    }

    // delete data
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        Alert::success('Success', 'Barang dihapus!');
        return redirect()->route('products.index');
    }
}
