<?php

namespace App\Jobs;

use App\Models\AiAnalysis;
use App\Services\OllamaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class RunAiAnalysis implements ShouldQueue
{
    use Queueable;

    public int $tries   = 3;
    public int $timeout = 180;

    public function __construct(private AiAnalysis $analysis) {}

    public function handle(OllamaService $ollama): void
    {
        Log::info('[Job] RunAiAnalysis started', [
            'analysis_id'   => $this->analysis->id,
            'analysis_type' => $this->analysis->analysis_type,
            'model'         => $this->analysis->model_name,
        ]);

        $this->analysis->update(['status' => 'processing', 'started_at' => now()]);

        try {
            $prompt = $this->analysis->input['prompt'] ?? '';
            $result = $ollama->analyze($prompt);

            $this->analysis->update([
                'status'       => 'completed',
                'result'       => ['response' => $result],
                'completed_at' => now(),
            ]);

            Log::info('[Job] RunAiAnalysis completed', [
                'analysis_id' => $this->analysis->id,
            ]);
        } catch (\Throwable $e) {
            $this->analysis->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
                'completed_at'  => now(),
            ]);

            Log::error('[Job] RunAiAnalysis failed', [
                'analysis_id' => $this->analysis->id,
                'error'       => $e->getMessage(),
            ]);
        }
    }
}
