<?php

namespace App\Http\Controllers\Api\website;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest;
use App\Http\Requests\HomeCardsRequest;
use App\Models\Feature;
use App\Services\FeatureService;
use Illuminate\Http\JsonResponse;

class FeatureApiController extends Controller
{

    protected $featureInput = ['name', 'title', 'brief', 'button_link', 'button_text', 'icon', 'image','description'];

    protected $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    public function list(): JsonResponse
    {

        $data = $this->featureService->list();

        return sendResponse($data, 'Features Retrieved Successfully');
    }

    public function create(FeatureRequest $request): JsonResponse
    {

        $request->validate(['icon' => 'required']);
        $data = $this->featureService->create($request->only($this->featureInput));

        return sendResponse($data, 'Features Created Successfully');

    }

    public function get(Feature $feature): JsonResponse
    {
        return sendResponse($feature, 'Feature Retrieved Successfully');

    }

    public function delete(Feature $feature): JsonResponse
    {
        $feature->delete();
        return sendResponse([], 'Feature Deleted Successfully');

    }

    public function update(Feature $feature, HomeCardsRequest $request): JsonResponse
    {
        $data = $this->featureService->update($request->only($this->featureInput), $feature);
        return sendResponse($data, 'Features updates Successfully');
    }


}
