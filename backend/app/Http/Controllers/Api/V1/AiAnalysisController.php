<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiAnalysisRequest;
use App\Http\Resources\AiAnalysisResource;
use App\Services\AiAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AiAnalysisController extends Controller
{
    public function __construct(private AiAnalysisService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $analyses = $this->service->index($request->user()->id);

        return AiAnalysisResource::collection($analyses);
    }

    public function store(AiAnalysisRequest $request): JsonResponse
    {
        $analysis = $this->service->create($request->validated(), $request->user()->id);

        return response()->json([
            'status'  => true,
            'message' => 'Analysis queued.',
            'data'    => new AiAnalysisResource($analysis),
        ], 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $analysis = $this->service->show($id, $request->user()->id);

        if (!$analysis) {
            return response()->json(['status' => false, 'message' => 'Not found.'], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => new AiAnalysisResource($analysis),
        ]);
    }
}
