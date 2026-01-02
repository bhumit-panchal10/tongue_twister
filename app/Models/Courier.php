<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;
    public $table = 'courier';
    protected $fillable = [
        'name',
        'tracking_url'
    ];
}
