<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AiAnalysisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'analysis_type'     => ['required', 'string', 'max:100'],
            'input'             => ['required', 'array'],
            'input.prompt'      => ['required', 'string', 'min:10'],
            'security_event_id' => ['nullable', 'integer', 'exists:security_events,id'],
            'incident_id'       => ['nullable', 'integer', 'exists:incidents,id'],
        ];
    }
}
