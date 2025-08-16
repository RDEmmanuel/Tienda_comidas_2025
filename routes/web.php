<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {

    //admin dashboard
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    //PRODUCTOS-------------------------------------------------------------------------------------------------------------
    Route::get('admin/productos', [ProductoController::class, 'index'])->name('admin.productos.index');

    //CRUD
    Route::get('admin/productos/create', [ProductoController::class, 'create'])->name('admin.productos.create');
    Route::post('admin/productos', [ProductoController::class, 'store'])->name('admin.productos.store');
    Route::get('admin/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('admin.productos.edit');
    Route::put('admin/productos/{producto}', [ProductoController::class, 'update'])->name('admin.productos.update');
    Route::delete('admin/productos/{producto}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');

    //mostrar producto
    Route::get('admin/productos/{producto}', [ProductoController::class, 'show'])->name('admin.productos.show');

    // Cambiar estado del producto (eliminar o restaurar)
    Route::patch('/productos/{id}/estado', [ProductoController::class, 'cambiar_estado'])->name('admin.productos.cambiar_estado');

    //CATEGORIAS-------------------------------------------------------------------------------------------------------------
    Route::get('admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index');

    //CRUD
    Route::get('admin/categorias/create', [CategoriaController::class, 'create'])->name('admin.categorias.create');
    Route::post('admin/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');
    Route::get('admin/categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('admin.categorias.edit');
    Route::put('admin/categorias/{categoria}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
    Route::delete('admin/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

    //mostrar categoria
    Route::get('admin/categorias/{categoria}', [CategoriaController::class, 'show'])->name('admin.categorias.show');


});

require __DIR__.'/auth.php';
