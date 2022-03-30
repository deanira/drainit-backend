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

// Route::middleware('auth:api-admin')->get('/user', function (Request $request) {
//     return auth()->user();
// });

// Route::prefix('login')->group(function () {
//     Route::post('admin', 'AdminController@login')->name('login.admin');
//     Route::post('petugas', 'PetugasController@login')->name('login.petugas');
//     Route::post('masyarakat', 'MasyarakatController@login')->name('login.masyarakat');
// });

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

Route::prefix('change_password')->group(function () {
    Route::put('/admin', 'AdminController@reset_password')->name('reset_password.admin')->middleware('auth:api-admin');
    Route::put('/petugas', 'PetugasController@reset_password')->name('reset_password.petugas')->middleware('auth:api-petugas');
    Route::put('/masyarakat', 'MasyarakatController@reset_password')->name('reset_password.masyarakat')->middleware('auth:api-masyarakat');
});
