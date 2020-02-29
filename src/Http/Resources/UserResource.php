<?php

namespace Bugphix\BugphixLaravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            // 'id' => $this->id,
            'user_unique' => $this->user_unique,
            'user_meta' => $this->user_meta,
            'user_initials' => $this->generate($info),
            'user_info' => $info,
        ];
    }

    /**
     * Generate initials from a name
     *
     * @param string $name
     * @return string
     */
    protected function generate(string $name): string
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        }
        return $this->makeInitialsFromSingleWord($name);
    }

    /**
     * Make initials from a word with no spaces
     *
     * @param string $name
     * @return string
     */
    private function makeInitialsFromSingleWord(string $name): string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return substr(implode('', $capitals[1]), 0, 2);
        }
        return strtoupper(substr($name, 0, 2));
    }
}
