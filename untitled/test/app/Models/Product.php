<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'image',
        'quantity'
    ];
    protected $dates = ['deleted_at'];
}
