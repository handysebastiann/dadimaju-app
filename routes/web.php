<?php

use App\Models\Product;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $total_products = Product::count();
    $total_stock = Product::sum('stock');

    $products_habis = Product::where('stock', '<=', 0)->take(5)->get();
    $products_menipis = Product::where('stock', '>', 0)->where('stock', '<', 5)->take(5)->get();

    return view('dashboard', compact('total_products', 'total_stock', 'products_habis', 'products_menipis'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
