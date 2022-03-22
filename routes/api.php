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

Route::middleware('auth:api-admin')->get('/user', function (Request $request) {
    return auth()->user();
});


Route::prefix('login')->group(function () {
    Route::post('admin', 'AdminController@login')->name('login.admin');
    Route::post('petugas', 'PetugasController@login')->name('login.petugas');
    Route::post('masyarakat', 'MasyarakatController@login')->name('login.masyarakat');
});

Route::prefix('register')->group(function () {
    Route::middleware('auth:api-admin')->group(function () {
        Route::post('admin', 'AdminController@register')->name('register.admin');
        Route::post('petugas', 'PetugasController@register')->name('register.petugas');
    });
    Route::post('masyarakat', 'MasyarakatController@register')->name('register.masyarakat');
});

Route::middleware('auth:api-admin')->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('get.admin');
    Route::get('/{id}', 'AdminController@show')->name('get_by_id.admin');
    Route::get('/profile', 'AdminController@profile')->name('get_loged_in_user.admin');
    Route::post('/logout', 'AdminController@logoutApi')->name('logout.admin');
    Route::put('/', 'AdminController@update')->name('update.admin');
    Route::delete('/{id}', 'AdminController@delete')->name('delete.admin');
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

Route::prefix('titik_banjir')->group(function () {
    Route::get('/', 'TitikBanjirController@index')->name('get.titk_banjir');
    Route::get('/{id}', 'TitikBanjirController@show')->name('get_by_id.titik_banjir');

    Route::middleware('auth:api-admin')->group(function () {
        Route::post('/', 'TitikBanjirController@create')->name('create.titik_bajir');
        Route::put('/{id}', 'TitikBanjirController@update')->name('update.titik_bajir');
        Route::delete('/{id}', 'TitikBanjirController@delete')->name('delete.titik_banjir');
    });
});

Route::prefix('titik_rusak')->group(function () {
    Route::get('/', 'TitikRusakController@index')->name('get.titik_tersumbat');
    Route::get('/{id}', 'TitikRusakController@show')->name('get_by_id.titik_tersumbat');

    Route::middleware('auth:api-admin')->group(function () {
        Route::post('/', 'TitikRusakController@create')->name('create.titik_tersumbat');
        Route::put('/{id}', 'TitikRusakController@update')->name('update.titik_tersumbat');
        Route::delete('/{id}', 'TitikRusakController@delete')->name('delete.titik_tersumbat');
    });
});

Route::prefix('drainase')->group(function () {
    Route::get('/', 'DrainaseController@index')->name('get.drainase');
    Route::get('/{id}', 'DrainaseController@show')->name('get_by_id.drainase');


    Route::middleware('auth:api-admin')->group(function () {
        Route::post('/', 'DrainaseController@create')->name('create.drainase');
        Route::put('/{i}', 'DrainaseController@update')->name('update.drainase');
        Route::delete('/{i}', 'DrainaseController@delete')->name('delete.drainase');
    });
});

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
});

Route::prefix('pembaruan_pengaduan')->group(function () {
    Route::middleware('auth:api-petugas')->group(function () {
        Route::post('/', 'PembaruanPengaduanController@create')->name('create.pembaruan_pengaduan');
    });
    Route::get('/{id}', 'PembaruanPengaduanController@get_by_id_pengaduan')->name('get_by_id_pengaduan.pembaruan_pengaduan');
});

Route::get('/pengaduan_by_tipe/{tipe}', 'PengaduanController@get_by_tipe')->name('get_by_tipe.pengaduan');
Route::get('/pengaduan_by_status/{status}', 'PengaduanController@get_by_status')->name('get_by_status.pengaduan');
Route::get('/pengaduan_by_status_sortedup/{status}', 'PengaduanController@get_by_status_sortedup')->name('get_by_status.pengaduan');
Route::get('/pengaduan_by_status_sorteddown/{status}', 'PengaduanController@get_by_status_sorteddown')->name('get_by_status.pengaduan');
Route::get('/pengaduan_by_tipe_n_status/{tipe}/{status}', 'PengaduanController@get_by_tipe_n_status')->name('get_by_tipe_n_status.pengaduan');
Route::get('/pengaduan_by_tipe_n_status_sortedup/{tipe}/{status}', 'PengaduanController@get_by_tipe_n_status_sortedup')->name('get_by_tipe_n_status.pengaduan');
Route::get('/pengaduan_by_tipe_n_status_sorteddown/{tipe}/{status}', 'PengaduanController@get_by_tipe_n_status_sorteddown')->name('get_by_tipe_n_status.pengaduan');

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

Route::get('/pengaduan_by_masyarakat', 'PengaduanController@get_by_masyarakat')->name('get_by_masyarakat.pengaduan')->middleware('auth:api-masyarakat');
Route::get('/pengaduan_by_petugas', 'PengaduanController@get_by_petugas')->name('get_by_petugas.pengaduan')->middleware('auth:api-petugas');
Route::get('/pengaduan_by_petugas_sortedup', 'PengaduanController@get_by_petugas_sortedup')->name('get_by_petugas.pengaduan')->middleware('auth:api-petugas');
Route::get('/pengaduan_by_petugas_sorteddown', 'PengaduanController@get_by_petugas_sorteddown')->name('get_by_petugas.pengaduan')->middleware('auth:api-petugas');
Route::get('/pengaduan_not_assign', 'PengaduanController@get_not_assign')->name('get_not_assign.pengaduan');
Route::get('/pengaduan_not_assign_sortedup', 'PengaduanController@get_not_assign_sortedup')->name('get_not_assign.pengaduan');
Route::get('/pengaduan_not_assign_sorteddown', 'PengaduanController@get_not_assign_sorteddown')->name('get_not_assign.pengaduan');
Route::get('/pengaduan_not_verified', 'PengaduanController@get_not_verified')->name('get_not_verified.pengaduan');

Route::prefix('update_pengaduan')->group(function () {
    Route::put('/admin/{id}', 'PengaduanController@updateAdmin')->middleware('auth:api-admin')->name('update_pengaduan.admin');
    Route::put('/petugas/{id}', 'PengaduanController@updatePetugas')->middleware('auth:api-petugas')->name('update_pengaduan.petugas');
    Route::put('/masyarakat/{id}', 'PengaduanController@feedbackMasyarakat')->middleware('auth:api-masyarakat')->name('feedback_pengaduan.masyarakat');;
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
