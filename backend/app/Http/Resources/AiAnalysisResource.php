<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiAnalysisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'analysis_type'     => $this->analysis_type,
            'model_name'        => $this->model_name,
            'status'            => $this->status,
            'input'             => $this->input,
            'result'            => $this->result,
            'error_message'     => $this->when($this->status === 'failed', $this->error_message),
            'security_event_id' => $this->security_event_id,
            'incident_id'       => $this->incident_id,
            'started_at'        => $this->started_at?->toISOString(),
            'completed_at'      => $this->completed_at?->toISOString(),
            'created_at'        => $this->created_at->toISOString(),
        ];
    }
}
