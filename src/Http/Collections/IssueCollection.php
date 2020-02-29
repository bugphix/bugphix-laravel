<?php

namespace Bugphix\BugphixLaravel\Http\Collections;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

// models
use Bugphix\BugphixLaravel\Models\Event;
use Bugphix\BugphixLaravel\Models\EventUser;

class IssueCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $event = Event::issueId($this->id);

        $eventUserArray = $event;
        $eventUser = EventUser::whereIn('event_id', $eventUserArray->pluck('id'))->count();

        $deletedAt = null;
        if ($this->deleted_at) {
            $deletedAt = [
                'date' => $this->deleted_at->toDateTimeString(),
                'formatted' => $this->deleted_at->format(config('bugphix.option.date_format')),
                'ago' => $this->deleted_at->diffForHumans()
            ];
        }

        return [
            'id' => $this->id,
            // 'issue_project_id' => $this->issue_project_id,
            'issue_error_exception' => $this->issue_error_exception,
            'issue_error_message' => [
                'full' => $this->issue_error_message,
                'excerpt' => Str::limit($this->issue_error_message, 80),
            ],
            'issue_status' => $this->issue_status,
            'issue_counts' => $event->count() ?? 1,
            'issue_users' => $eventUser ?? 0,
            'created_at' => [
                'date' => $this->created_at->toDateTimeString(),
                'formatted' => $this->created_at->format(config('bugphix.option.date_format')),
                'ago' => $this->created_at->diffForHumans()
            ],
            'updated_at' => [
                'date' => $this->updated_at->toDateTimeString(),
                'formatted' => $this->updated_at->format(config('bugphix.option.date_format')),
                'ago' => $this->updated_at->diffForHumans()
            ],
            'deleted_at' => $deletedAt,
        ];
    }
}
