<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Votes extends Model
{
    //
    protected $fillable = [
        'id_voter', 'vote', 'id_pengaduan',
    ];
}
