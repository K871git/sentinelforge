<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaService
{
    private string $baseUrl;
    private string $model;

    public function __construct()
    {
        $this->baseUrl = config('services.ollama.url');
        $this->model   = config('services.ollama.model');
    }

    public function analyze(string $prompt): string
    {
        Log::info('[Ollama] Sending request', [
            'model'         => $this->model,
            'prompt_length' => strlen($prompt),
        ]);

        $start    = microtime(true);
        $response = Http::timeout(120)->post("{$this->baseUrl}/api/generate", [
            'model'  => $this->model,
            'prompt' => $prompt,
            'stream' => false,
        ]);
        $elapsed  = round(microtime(true) - $start, 2);

        if ($response->failed()) {
            Log::error('[Ollama] Request failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Ollama request failed: ' . $response->body());
        }

        Log::info('[Ollama] Response received', [
            'elapsed_seconds' => $elapsed,
            'response_length' => strlen($response->json('response', '')),
        ]);

        return $response->json('response', '');
    }
}
