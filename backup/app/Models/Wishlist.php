<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    public $table = 'wishlist';
    protected $fillable = [
        'customerid',
        'productid',
        'iStatus',
        'isDelete',
        'created_at',
        'strIP'
    ];
}
