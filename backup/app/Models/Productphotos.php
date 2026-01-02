<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productphotos extends Model
{
    use HasFactory;
    public $table = 'productphotos';
    protected $fillable = [
        'productid',
        'strphoto'
    ];
}
