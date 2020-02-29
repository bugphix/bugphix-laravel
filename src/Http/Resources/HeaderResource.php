<?php

namespace Bugphix\BugphixLaravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeaderResource extends JsonResource
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
        // return [
        //     'id' => $this->id,
        //     'header_event_id' => $this->header_event_id,
        //     'header_info' => $this->header_info,
        // ];

        return $this->header_info;
    }
}
