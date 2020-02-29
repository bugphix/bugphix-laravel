<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class EventClient extends Model
{
    public $table = 'bugphix_event_clients';

    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'client_id',
    ];

    public function scopeEventId($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeClientId($query, int $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function event()
    {
        return $this->belongsTo('Bugphix\BugphixLaravel\Models\Event');
    }

    public function client()
    {
        return $this->belongsTo('Bugphix\BugphixLaravel\Models\Client');
    }
}
