<?php

use App\PembaruanPengaduan;
use Illuminate\Http\Request;

Route::prefix('login')->group(function () {
    Route::post('masyarakat', 'MasyarakatController@login')->name('login.masyarakat');
});

Route::prefix('masyarakat')->group(function () {
    Route::middleware('auth:api-masyarakat')->group(function () {
        Route::get('/profile', 'MasyarakatController@profile')->name('get_loged_in_user.masyarakat');;
        Route::put('/', 'MasyarakatController@update')->name('update.masyarakat');
        Route::post('/logout', 'MasyarakatController@logoutApi')->name('logout.masyarakat');
    });
    Route::middleware('auth:api-admin,auth:api-petugas')->group(function () {
        Route::get('/', 'MasyarakatController@index')->name('get.masyarakat');
        Route::get('/{id}', 'MasyarakatController@show')->name('get_by_id.masyarakat');
        Route::delete('/{id}', 'MasyarakatController@delete')->name('delete.masyarakat');
    });
});
