<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'manufacturer',
        'additional',
        'availability',
        'price',
        'product_image',
        'product_ref_id'
    ];
}
