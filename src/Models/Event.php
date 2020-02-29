<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $table = 'bugphix_events';

    protected $fillable = [
        'event_issue_id',
        'event_environment',
    ];

    public function scopeIssueId($query, int $issueId)
    {
        return $query->where('event_issue_id', $issueId);
    }

    public function user()
    {
        return $this->hasOne('Bugphix\BugphixLaravel\Models\EventUser');
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
