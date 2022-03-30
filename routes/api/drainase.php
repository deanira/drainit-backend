<?php

Route::prefix('drainase')->group(function () {
    Route::get('/', 'DrainaseController@index')->name('get.drainase');
    Route::get('/{id}', 'DrainaseController@show')->name('get_by_id.drainase');


    Route::middleware('auth:api-admin')->group(function () {
        Route::post('/', 'DrainaseController@create')->name('create.drainase');
        Route::put('/{i}', 'DrainaseController@update')->name('update.drainase');
        Route::delete('/{i}', 'DrainaseController@delete')->name('delete.drainase');
    });
});
