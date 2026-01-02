<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCouponApplyed extends Model
{
    use HasFactory;
    public $table = 'customercouponapplyed';
    protected $fillable = [
        'offerId',
        'customerId',
        'result',
        'strIP',
    ];
}
