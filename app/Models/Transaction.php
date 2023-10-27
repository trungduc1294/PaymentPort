<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'amount',
        'timestamp',
        'result',
        'payment_status',
        'payment_desc',
        'payment_gateway',
        'payment_gateway_data',
    ];

    protected $casts = [
        'payment_gateway_data' => 'array',
    ];
}
