<?php

namespace Bugphix\BugphixLaravel\Http\Collections;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
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

        $info = $this->user_meta['name']
            ?? $this->user_meta['email']
            ?? $this->user_meta['username']
            ?? $this->user_unique;
        return [
            'id' => $this->id,
            'user_unique' => $this->user_unique,
            'user_info' => $info,
        ];
    }
}
