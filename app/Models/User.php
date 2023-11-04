<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email',
        'full_name',
        'user_type',
        'role_id',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts () {
        return $this->belongsToMany(Post::class, 'user_post', 'user_id', 'post_id');
    }
}
