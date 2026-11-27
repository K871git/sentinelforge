<?php

namespace App\Services;

use App\Jobs\RunAiAnalysis;
use App\Models\AiAnalysis;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class AiAnalysisService
{
    public function index(int $userId): LengthAwarePaginator
    {
        return AiAnalysis::where('user_id', $userId)
            ->latest()
            ->paginate(15);
    }

    public function create(array $data, int $userId): AiAnalysis
    {
        $analysis = AiAnalysis::create([
            'user_id'           => $userId,
            'analysis_type'     => $data['analysis_type'],
            'model_name'        => config('services.ollama.model'),
            'status'            => 'pending',
            'input'             => $data['input'],
            'security_event_id' => $data['security_event_id'] ?? null,
            'incident_id'       => $data['incident_id'] ?? null,
        ]);

        RunAiAnalysis::dispatch($analysis);

        Log::info('[AiAnalysisService] Analysis created and job dispatched', [
            'analysis_id'   => $analysis->id,
            'analysis_type' => $analysis->analysis_type,
            'user_id'       => $userId,
        ]);

        return $analysis;
    }

    public function show(int $id, int $userId): ?AiAnalysis
    {
        return AiAnalysis::where('id', $id)->where('user_id', $userId)->first();
    }
}
