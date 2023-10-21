<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presenter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'extra_page',
        'order_id',
    ];
}
