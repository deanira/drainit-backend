<?php

Route::prefix('pengaduan')->group(function () {
    Route::get('/', 'PengaduanController@index')->name('get.pengaduan');
    Route::get('/{id}', 'PengaduanController@show')->name('get_by_id.pengaduan');
    Route::post('/anonim', 'PengaduanController@anonim')->name('create_anonim.pengaduan');

    Route::middleware('auth:api-masyarakat')->group(function () {
        Route::post('/', 'PengaduanController@create')->name('create.pengaduan');
    });

    Route::middleware('auth:api-admin')->group(function () {
        Route::delete('/{id}', 'PengaduanController@delete')->name('delete.pengaduan');;
    });

    Route::put('/feedback/{id}', 'PengaduanController@feedbackMasyarakat')->middleware('auth:api-masyarakat')->name('feedback_pengaduan.masyarakat');
    Route::put('/verify/{id}', 'PengaduanController@verify')->middleware('auth:api-admin')->name('verify.pengaduan');
    Route::put('/reject/{id}', 'PengaduanController@reject')->middleware('auth:api-admin')->name('reject.pengaduan');
    Route::put('/done/{id}', 'PengaduanController@done')->middleware('auth:api-petugas')->name('done.pengaduan');
});

Route::get('/pengaduan_by_tipe/{tipe}', 'PengaduanController@get_by_tipe')->name('get_by_tipe.pengaduan');
Route::get('/pengaduan_by_status/{status}', 'PengaduanController@get_by_status')->name('get_by_status.pengaduan');
Route::get('/pengaduan_by_status_sortedup/{status}', 'PengaduanController@get_by_status_sortedup')->name('get_by_status.pengaduan');
Route::get('/pengaduan_by_status_sorteddown/{status}', 'PengaduanController@get_by_status_sorteddown')->name('get_by_status.pengaduan');
Route::get('/pengaduan_by_tipe_n_status/{tipe}/{status}', 'PengaduanController@get_by_tipe_n_status')->name('get_by_tipe_n_status.pengaduan');
Route::get('/pengaduan_by_tipe_n_status_sortedup/{tipe}/{status}', 'PengaduanController@get_by_tipe_n_status_sortedup')->name('get_by_tipe_n_status.pengaduan');
Route::get('/pengaduan_by_tipe_n_status_sorteddown/{tipe}/{status}', 'PengaduanController@get_by_tipe_n_status_sorteddown')->name('get_by_tipe_n_status.pengaduan');
Route::get('/pengaduan_by_masyarakat', 'PengaduanController@get_by_masyarakat')->name('get_by_masyarakat.pengaduan')->middleware('auth:api-masyarakat');
Route::get('/pengaduan_by_petugas', 'PengaduanController@get_by_petugas')->name('get_by_petugas.pengaduan')->middleware('auth:api-petugas');
Route::get('/pengaduan_by_petugas_sortedup', 'PengaduanController@get_by_petugas_sortedup')->name('get_by_petugas.pengaduan')->middleware('auth:api-petugas');
Route::get('/pengaduan_by_petugas_sorteddown', 'PengaduanController@get_by_petugas_sorteddown')->name('get_by_petugas.pengaduan')->middleware('auth:api-petugas');
Route::get('/pengaduan_not_assign', 'PengaduanController@get_not_assign')->name('get_not_assign.pengaduan');
Route::get('/pengaduan_not_assign_sortedup', 'PengaduanController@get_not_assign_sortedup')->name('get_not_assign.pengaduan');
Route::get('/pengaduan_not_assign_sorteddown', 'PengaduanController@get_not_assign_sorteddown')->name('get_not_assign.pengaduan');
Route::get('/pengaduan_not_verified', 'PengaduanController@get_not_verified')->name('get_not_verified.pengaduan');

Route::prefix('pembaruan_pengaduan')->group(function () {
    Route::middleware('auth:api-petugas')->group(function () {
        Route::post('/', 'PembaruanPengaduanController@create')->name('create.pembaruan_pengaduan');
    });
    Route::get('/{id}', 'PembaruanPengaduanController@get_by_id_pengaduan')->name('get_by_id_pengaduan.pembaruan_pengaduan');
});

Route::get('/pengaduanwithvote', 'PengaduanController@listwithvote')->middleware('auth:api-masyarakat');

Route::prefix('votes')->group(function () {
    Route::get('/', 'VoteController@index');
    Route::get('/upcount/{id}', 'VoteController@upcount');
    Route::get('/downcount/{id}', 'VoteController@downcount');
    Route::post('/', 'VoteController@create')->middleware('auth:api-masyarakat');
    Route::put('/{id}', 'VoteController@update')->middleware('auth:api-masyarakat');
    Route::delete('/{id}', 'VoteController@destroy')->middleware('auth:api-masyarakat');
});

Route::prefix('update_pengaduan')->group(function () {
    Route::put('/admin/{id}', 'PengaduanController@updateAdmin')->middleware('auth:api-admin')->name('update_pengaduan.admin');
    Route::put('/petugas/{id}', 'PengaduanController@updatePetugas')->middleware('auth:api-petugas')->name('update_pengaduan.petugas');
    Route::put('/masyarakat/{id}', 'PengaduanController@feedbackMasyarakat')->middleware('auth:api-masyarakat')->name('feedback_pengaduan.masyarakat');
});
