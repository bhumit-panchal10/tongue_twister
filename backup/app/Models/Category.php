<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table = 'category';
    protected $fillable = [
        'categoryname',
        'slugname',
        'strGST',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at',
        'strIP'
    ];
}
