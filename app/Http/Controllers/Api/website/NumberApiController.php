<?php

namespace App\Http\Controllers\Api\website;

use App\Http\Controllers\Controller;
use App\Http\Requests\NumberRequest;
use App\Http\Requests\HomeCardsRequest;
use App\Models\Number;
use App\Services\NumberService;
use Illuminate\Http\JsonResponse;

class NumberApiController extends Controller
{
    protected $NumberInput = ['icon', 'text', 'number'];

    protected $NumberService;

    public function __construct(NumberService $NumberService)
    {
        $this->NumberService = $NumberService;
    }

    public function list(): JsonResponse
    {

        $data = $this->NumberService->list();

        return sendResponse($data, 'Numbers Retrieved Successfully');
    }

    public function create(NumberRequest $request): JsonResponse
    {

        $request->validate(['icon' => 'required']);
        $data = $this->NumberService->create($request->only($this->NumberInput));

        return sendResponse($data, 'Numbers Created Successfully');

    }

    public function get(Number $number): JsonResponse
    {
        return sendResponse($number, 'Number Retrieved Successfully');

    }

    public function delete(Number $number): JsonResponse
    {
        $number->delete();
        return sendResponse([], 'Number Deleted Successfully');

    }

    public function update(Number $number, NumberRequest $request): JsonResponse
    {
        $data = $this->NumberService->update($request->only($this->NumberInput), $number);
        return sendResponse($data, 'Numbers updates Successfully');
    }


}
