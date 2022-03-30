<?php

Route::prefix('titik_banjir')->group(function () {
    Route::get('/', 'TitikBanjirController@index')->name('get.titk_banjir');
    Route::get('/{id}', 'TitikBanjirController@show')->name('get_by_id.titik_banjir');

    Route::middleware('auth:api-admin')->group(function () {
        Route::post('/', 'TitikBanjirController@create')->name('create.titik_bajir');
        Route::put('/{id}', 'TitikBanjirController@update')->name('update.titik_bajir');
        Route::delete('/{id}', 'TitikBanjirController@delete')->name('delete.titik_banjir');
    });
});
