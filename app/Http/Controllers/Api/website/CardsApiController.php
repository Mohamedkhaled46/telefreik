<?php

namespace App\Http\Controllers\Api\website;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeCardsRequest;
use App\Models\HomeCards;
use App\Services\HomeCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CardsApiController extends Controller
{

    protected $cardService;

    public function __construct(HomeCardService $cardService)
    {
        $this->cardService = $cardService;
    }

    public function list(): JsonResponse
    {

        $data = $this->cardService->list();

        return sendResponse($data, 'Home Cards Retrieved Successfully');
    }

    public function create(HomeCardsRequest $request): JsonResponse
    {
        $request->validate(['icon'=>'required']);

        $data = $this->cardService->create($request->only(['title', 'icon', 'description',]));

        return sendResponse($data, 'Home Cards Created Successfully');

    }
    public function delete(HomeCards $card): JsonResponse
    {
        $card->delete();
        return sendResponse([], 'Home Card Deleted Successfully');

    }
    public function get(HomeCards $card): JsonResponse
    {
        return sendResponse($card, 'Home Card Retrieved Successfully');

    }

    public function update(HomeCards $card,HomeCardsRequest $request): JsonResponse
    {
        $data = $this->cardService->update($request->only(['title', 'icon', 'description',]), $card);
        return sendResponse($data, 'Home Cards updates Successfully');
    }


}
