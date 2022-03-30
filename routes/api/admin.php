<?php

use App\PembaruanPengaduan;
use Illuminate\Http\Request;

Route::prefix('login')->group(function () {
    Route::post('admin', 'AdminController@login')->name('login.admin');
});

Route::middleware('auth:api-admin')->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('get.admin');
    Route::get('/{id}', 'AdminController@show')->name('get_by_id.admin');
    Route::get('/profile', 'AdminController@profile')->name('get_loged_in_user.admin');
    Route::post('/logout', 'AdminController@logoutApi')->name('logout.admin');
    Route::put('/', 'AdminController@update')->name('update.admin');
    Route::delete('/{id}', 'AdminController@delete')->name('delete.admin');
});
