<?php

namespace Bugphix\BugphixLaravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// models
use Bugphix\BugphixLaravel\Models\Issue;
use Bugphix\BugphixLaravel\Models\Event;

class ProjectResource extends JsonResource
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
        $issueTable = Issue::getTableName();
        $eventTable = Event::getTableName();
        $issue = Issue::projectId($this->project_id)->count();
        $event = Issue::where("{$issueTable}.issue_project_id", $this->project_id)
            ->join($eventTable, "{$eventTable}.event_issue_id", "{$issueTable}.id")
            ->select([
                "{$eventTable}.id",
                "{$eventTable}.event_issue_id",
                "{$issueTable}.id",
                "{$issueTable}.issue_project_id"
            ])
            ->count();

        $deletedAt = null;
        if ($this->deleted_at) {
            $deletedAt = [
                'date' => $this->deleted_at->toDateTimeString(),
                'formatted' => $this->deleted_at->format(config('bugphix.option.date_format')),
                'ago' => $this->deleted_at->diffForHumans()
            ];
        }

        return [
            'project_id' => $this->project_id,
            'project_name' => $this->project_name,
            'project_platform' => $this->project_platform,
            'project_token' => $this->project_token,
            'is_active' => $this->is_active,
            'issues' => $issue,
            'events' => $event,
            'issue_table' => $issueTable ?? '',
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
