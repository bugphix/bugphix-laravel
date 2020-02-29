<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'bugphix_users';

    public $timestamps = false;

    protected $fillable = [
        'user_unique',
        'user_meta',
    ];

    protected $casts = [
        'user_meta' => 'array',
    ];

    public function scopeSearchUser($query, $keyword = '')
    {
        if (!$keyword) return $query;
        return $query->where('user_unique', 'LIKE', "%$keyword%")
            ->orWhere('user_meta', 'LIKE', "%$keyword%");
    }
}
