<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory;
    public $table = 'product_attributes';
    protected $fillable = [
        'product_id',
        'product_attribute_id',
        'product_attribute_qty',
        'product_attribute_weight',
        'product_attribute_price'
    ];
}
