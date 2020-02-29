<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    public $table = 'bugphix_event_users';

    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'user_id',
    ];

    public function scopeEventId($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeUserId($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function event()
    {
        return $this->belongsTo('Bugphix\BugphixLaravel\Models\Event');
    }

    public function user()
    {
        return $this->belongsTo('Bugphix\BugphixLaravel\Models\User');
    }
}
