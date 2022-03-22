<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class PembaruanPengaduan extends Model
{
    protected $fillable = [
        'id_pengaduan',
        'id_petugas',
        'judul',
        'deskripsi',
        'foto',
        'waktu',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'id_pengaduan',
        'id_petugas'
    ];
}
