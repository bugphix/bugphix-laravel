<?php

namespace Bugphix\BugphixLaravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
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
        return [
            // 'id' => $this->id,
            'server_name' => $this->server_name,
            'server_os' => $this->server_os,
            'server_os_version' => $this->server_os_version,
            'server_runtime' => $this->server_runtime,
        ];
    }
}
