<?php

use App\PembaruanPengaduan;
use Illuminate\Http\Request;

Route::prefix('titik_rusak')->group(function () {
    Route::get('/', 'TitikRusakController@index')->name('get.titik_tersumbat');
    Route::get('/{id}', 'TitikRusakController@show')->name('get_by_id.titik_tersumbat');

    Route::middleware('auth:api-admin')->group(function () {
        Route::post('/', 'TitikRusakController@create')->name('create.titik_tersumbat');
        Route::put('/{id}', 'TitikRusakController@update')->name('update.titik_tersumbat');
        Route::delete('/{id}', 'TitikRusakController@delete')->name('delete.titik_tersumbat');
    });
});
