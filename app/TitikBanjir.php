<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TitikBanjir extends Model
{

    protected $fillable = [
        'id_admin', 'geometry', 'nama_jalan', 'kondisi_kerusakan', 'foto','keterangan', 'status'
    ];
    protected $spatialFields = [
        'geometry'
    ];
    protected $hidden = [
        'id_admin',
    ];
}
