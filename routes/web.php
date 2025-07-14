<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\BarangMasukController;
Route::get('/', function () {
    return redirect(route('barang.index'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
            Route::get('', 'index')->name('index')->middleware('role_or_permission:admin|user_index');
            Route::post('create', 'create')->name('create')->middleware('role_or_permission:admin|user_create');
            Route::put('status', 'status')->name('status')->middleware('role_or_permission:admin|user_show');
            Route::put('', 'update')->name('update')->middleware('role_or_permission:admin|user_update');
            Route::delete('delete', 'delete')->name('delete')->middleware('role_or_permission:admin|user_delete');
    });
     Route::controller(KategoriController::class)->prefix('kategori')->name('kategori.')->group(function () {
            Route::get('', 'index')->name('index')->middleware('role_or_permission:admin|kategori_index');
            Route::post('create', 'create')->name('create')->middleware('role_or_permission:admin|kategori_create');
            Route::put('', 'update')->name('update')->middleware('role_or_permission:admin|kategori_update');
            Route::delete('delete', 'delete')->name('delete')->middleware('role_or_permission:admin|kategori_delete');
    });
    Route::controller(SubKategoriController::class)->prefix('subkategori')->name('subkategori.')->group(function () {
            Route::get('', 'index')->name('index')->middleware('role_or_permission:admin|sub_kategori_index');
            Route::post('create', 'create')->name('create')->middleware('role_or_permission:admin|sub_kategori_create');
            Route::put('', 'update')->name('update')->middleware('role_or_permission:admin|sub_kategori_update');
            Route::delete('delete', 'delete')->name('delete')->middleware('role_or_permission:admin|sub_kategori_delete');
    });
    Route::controller(BarangMasukController::class)->prefix('barang')->name('barang.')->group(function () {
            Route::get('', 'index')->name('index')->middleware('role_or_permission:admin|barang_masuk_index');
            Route::get('kategori/{id}', 'subkategori')->name('subkategori');
            Route::get('create', 'create')->name('create')->middleware('role_or_permission:admin|barang_masuk_create');
            Route::get('update/{id}', 'update')->name('update')->middleware('role_or_permission:admin|barang_masuk_update');
            Route::post('update/{id}', 'edit')->name('edit')->middleware('role_or_permission:admin|barang_masuk_update');
            Route::post('store', 'store')->name('store')->middleware('role_or_permission:admin|barang_masuk_create');
            Route::get('export', 'export')->name('export')->middleware('role_or_permission:admin|barang_masuk_index');
            Route::delete('delete', 'delete')->name('delete')->middleware('role_or_permission:admin|barang_masuk_delete');
            Route::post('status', 'status')->name('status')->middleware('role_or_permission:admin|barang_masuk_index');
    });
});