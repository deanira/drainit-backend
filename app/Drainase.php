<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Drainase extends Model
{
    protected $fillable = [
        'id_admin', 'nama_jalan',
        'foto', 'panjang',
        'lebar', 'kedalaman',
        'bahan', 'kondisi',
        'arah_alir','akhir_pembuangan',
        'tipe_drainase','geometry'
    ];
    protected $spatialFields = [
        'geometry'
    ];
    protected $hidden = [
        'id_admin',
    ];

}
