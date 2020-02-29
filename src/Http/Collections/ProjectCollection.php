<?php

namespace Bugphix\BugphixLaravel\Http\Collections;

use Illuminate\Http\Resources\Json\JsonResource;

// models
use Bugphix\BugphixLaravel\Models\Issue;

class ProjectCollection extends JsonResource
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
        $issue = Issue::projectId($this->project_id)->count();

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
            'is_active' => $this->is_active,
            'issues' => $issue,
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
