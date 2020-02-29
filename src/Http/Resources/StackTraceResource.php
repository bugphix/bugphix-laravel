<?php

namespace Bugphix\BugphixLaravel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StackTraceResource extends JsonResource
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
            // 'stack_trace_event_id' => $this->stack_trace_event_id,
            'stack_trace_error_file' => $this->stack_trace_error_file,
            'stack_trace_error_line' => $this->stack_trace_error_line,
            'stack_trace_start_line' => $this->stack_trace_start_line,
            'stack_trace_end_line' => $this->stack_trace_end_line,
            'stack_trace_data' => $this->stack_trace_data,
            'stack_trace_full_log' => $this->stack_trace_full_log,
        ];
    }
}
