<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'id', 'kategori'
    ];
}
