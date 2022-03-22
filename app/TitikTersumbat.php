<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;


class TitikRusak extends Model
{
    protected $fillable = [
        'id_admin', 'geometry', 'nama_jalan', 'foto','keterangan', 'status'
    ];
    protected $spatialFields = [
        'geometry'
    ];
    protected $hidden = [
        'id_admin',
    ];
}
