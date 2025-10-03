<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PokemonCache extends Model
{
    protected $connection = 'mongodb';          // matches config/database.php key
    protected $collection = 'pokemon_cache';    // collection name
    public $timestamps   = false;

    protected $primaryKey = '_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['_id','name','data','fetched_at'];

    protected $casts = [
        'data'       => 'array',
        'fetched_at' => 'datetime',
    ];
}
