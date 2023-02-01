<?php

namespace App\Http\Controllers\Api\website;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutCardsRequest;
use App\Http\Requests\HomeCardsRequest;
use App\Models\AboutCards;
use App\Models\HomeCards;
use App\Services\AboutCardService;
use App\Services\HomeCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AboutCardsApiController extends Controller
{

    protected $cardService;

    public function __construct(AboutCardService $cardService)
    {
        $this->cardService = $cardService;
    }

    public function list(): JsonResponse
    {

        $data = $this->cardService->list();

        return sendResponse($data, 'About Cards Retrieved Successfully');
    }

    public function create(AboutCardsRequest $request): JsonResponse
    {

        $request->validate(['icon' => 'required']);
        $data = $this->cardService->create($request->only(['title', 'icon', 'description',]));

        return sendResponse($data, 'About Cards Created Successfully');

    }

    public function get(AboutCards $card): JsonResponse
    {
        return sendResponse($card, 'About Card Retrieved Successfully');

    }

    public function delete(AboutCards $card): JsonResponse
    {
        $card->delete();
        return sendResponse([], 'About Card Deleted Successfully');

    }

    public function update(AboutCards $card, HomeCardsRequest $request): JsonResponse
    {
        $data = $this->cardService->update($request->only(['title', 'icon', 'description',]), $card);
        return sendResponse($data, 'About Cards updates Successfully');
    }


}
