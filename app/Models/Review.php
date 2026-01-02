<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $table = 'review';
    protected $fillable = [
       'id', 'iCustomerId', 'comment', 'product_id', 'author', 'email', 'rating','status'
    ];
}
