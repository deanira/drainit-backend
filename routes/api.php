<?php

use App\PembaruanPengaduan;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('register')->group(function () {
    Route::middleware('auth:api-admin')->group(function () {
        Route::post('admin', 'AdminController@register')->name('register.admin');
        Route::post('petugas', 'PetugasController@register')->name('register.petugas');
    });
    Route::post('masyarakat', 'MasyarakatController@register')->name('register.masyarakat');
});

Route::prefix('kategori')->group(function () {
    Route::get('/', 'KategoriController@index')->name('get.kategori');
    Route::get('/{id}', 'KategoriController@show')->name('get_by_id.kategori');

    Route::middleware('auth:api-admin')->group(function () {
        Route::post('/', 'KategoriController@create')->name('create.kategori');
        Route::put('/{id}', 'KategoriController@update')->name('update.kategori');
        Route::delete('/{id}', 'KategoriController@delete')->name('delete.kategori');
    });
});
