<?php

Route::prefix('login')->group(function () {
    Route::post('petugas', 'PetugasController@login')->name('login.petugas');
});

Route::prefix('petugas')->group(function () {
    Route::middleware('auth:api-petugas')->group(function () {
        Route::get('/profile', 'PetugasController@profile')->name('get_loged_in_user.petugas');
        //Route::put('/','PetugasController@update')->name('update.petugas');
        Route::post('/logout', 'PetugasController@logoutApi')->name('logout.petugas');
    });
    Route::middleware('auth:api-admin,auth:api-petugas')->group(function () {
        Route::get('/', 'PetugasController@index')->name('get.petugas');
        Route::get('/{id}', 'PetugasController@show')->name('get_by_id.petugas');
        Route::put('/{id}', 'PetugasController@update_by_admin')->name('update_by_admin.petugas');
        Route::delete('/{id}', 'PetugasController@delete')->name('delete.petugas');
    });
});

Route::prefix('change_password')->group(function () {
    Route::put('/petugas', 'PetugasController@reset_password')->name('reset_password.petugas')->middleware('auth:api-petugas');
});
