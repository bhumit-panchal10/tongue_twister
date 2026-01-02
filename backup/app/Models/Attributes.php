<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    public $table = 'attributes';
    protected $fillable = [
        'name',
        'slug',
        'display_as'
    ];
}
