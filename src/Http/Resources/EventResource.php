<?php

namespace Bugphix\BugphixLaravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// models
use Bugphix\BugphixLaravel\Models\StackTrace;
use Bugphix\BugphixLaravel\Models\EventClient;
use Bugphix\BugphixLaravel\Models\EventUser;
use Bugphix\BugphixLaravel\Models\EventServer;

class EventResource extends JsonResource
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

        $user = EventUser::eventid($this->id)->first();
        if ($user) $user = new UserResource($user->user);

        $client = EventClient::eventid($this->id)->first();
        if ($client) $client = new ClientResource($client->client);

        $server = EventServer::eventid($this->id)->first();
        if ($server) $server = new ServerResource($server->server);

        $stackTrace = StackTrace::eventid($this->id)->first();
        if ($stackTrace) $stackTrace = new StackTraceResource($stackTrace);

        return [
            'id' => $this->id,
            'event_issue_id' => $this->event_issue_id,
            'event_environment' => $this->event_environment,
            'user' => $user ?? '',
            'client' => $client ?? '',
            'server' => $server ?? '',
            'stack_trace' => $stackTrace ?? '',
            'updated_at' => [
                'date' => $this->updated_at->toDateTimeString(),
                'formatted' => $this->updated_at->format(config('bugphix.option.date_format')),
                'ago' => $this->updated_at->diffForHumans()
            ],
            'created_at' => [
                'date' => $this->created_at->toDateTimeString(),
                'formatted' => $this->created_at->format(config('bugphix.option.date_format')),
                'ago' => $this->created_at->diffForHumans()
            ],
        ];
    }
}
