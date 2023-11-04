<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'author_name',
        'title',
        'status',
    ];

    public function authors()
    {
        return $this->belongsToMany(User::class, 'user_post', 'post_id', 'user_id');
    }
}
