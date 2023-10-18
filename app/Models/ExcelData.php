<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExcelData extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'post_id',
        'author_name',
        'title',
        'email',
    ];
}
