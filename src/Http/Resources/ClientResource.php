<?php

namespace Bugphix\BugphixLaravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'client_method' => $this->client_method,
            'client_url' => $this->client_url,
            'client_browser' => $this->client_browser,
            'client_browser_version' => $this->client_browser_version,
            'client_os' => $this->client_os,
            'client_ip' => $this->client_ip,
            'client_header' => $this->client_header,
        ];
    }
}
