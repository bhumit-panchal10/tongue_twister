<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMultiple extends Model
{
    use HasFactory;
    public $table = 'multiplecategory';
    protected $fillable = [
        'productid',
        'categoryid'
    ];
}
