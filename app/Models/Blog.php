<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    public $table = 'blog';
    protected $fillable = [
        'blogId',
        'strTitle',
        'strSlug',
        'strDescription',
        'strPhoto',
        'metaTitle',
        'metaKeyword',
        'metaDescription',
        'head',
        'body',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at',
        'strIP'
    ];
}
