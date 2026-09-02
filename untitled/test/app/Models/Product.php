<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'price',
        'image',
        'quantity'
    ];

    protected $casts = [
        'price' => 'integer',
        'quantity' => 'integer',
        'deleted_at' => 'datetime',
    ];
}
