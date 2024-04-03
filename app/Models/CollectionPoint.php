<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionPoint extends Model
{
    use HasFactory;
    protected $table = 'collection_points'; 

    protected $fillable = [
        'agency',
        'code',
        'name',
        'address',
        'postal_code',
        'city',
        'state',
        'country',
        'country_iso',
        'longitude',
        'latitude',
        'schedule'
    ];


}
