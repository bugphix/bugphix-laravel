<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class EventServer extends Model
{
    public $table = 'bugphix_event_servers';

    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'server_id',
    ];

    public function scopeEventId($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeServerId($query, int $serverID)
    {
        return $query->where('server_id', $serverID);
    }

    public function event()
    {
        return $this->belongsTo('Bugphix\BugphixLaravel\Models\Event');
    }

    public function server()
    {
        return $this->belongsTo('Bugphix\BugphixLaravel\Models\Server');
    }
}
