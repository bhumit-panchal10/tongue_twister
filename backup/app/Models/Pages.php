<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
    public $table = 'pages';

    protected $fillable = [
        'Name',
        'Title',
        'Description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',

    ];
}