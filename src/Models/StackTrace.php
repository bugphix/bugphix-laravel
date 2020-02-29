<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class StackTrace extends Model
{
    public $table = 'bugphix_stack_trace';

    public $timestamps = false;

    protected $fillable = [
        'stack_trace_event_id',
        'stack_trace_error_file',
        'stack_trace_error_line',
        'stack_trace_start_line',
        'stack_trace_full_log',
        'stack_trace_data',
    ];

    protected $casts = [
        'stack_trace_data' => 'array',
    ];

    public function scopeEventId($query, int $eventId)
    {
        return $query->where('stack_trace_event_id', $eventId);
    }
}
