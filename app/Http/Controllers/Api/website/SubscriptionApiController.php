<?php

namespace App\Http\Controllers\Api\website;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;

class SubscriptionApiController extends Controller
{
    protected $SubscriptionInput = ['name', 'email'];

    protected $SubscriptionService;

    public function __construct(SubscriptionService $SubscriptionService)
    {
        $this->SubscriptionService = $SubscriptionService;
    }

    public function list(): JsonResponse
    {

        $data = $this->SubscriptionService->list();

        return sendResponse($data, 'Subscriptions Retrieved Successfully');
    }

    public function create(SubscriptionRequest $request): JsonResponse
    {

        $data = $this->SubscriptionService->create($request->only($this->SubscriptionInput));

        return sendResponse($data, 'Subscriptions Created Successfully');

    }

    public function get(Subscription $subscription): JsonResponse
    {
        return sendResponse($subscription, 'Subscription Retrieved Successfully');

    }

    public function delete(Subscription $subscription): JsonResponse
    {
        $subscription->delete();
        return sendResponse([], 'Subscription Deleted Successfully');

    }

    public function update(Subscription $card, SubscriptionRequest $request): JsonResponse
    {
        $data = $this->SubscriptionService->update($request->only($this->SubscriptionInput), $card);
        return sendResponse($data, 'Subscriptions updates Successfully');
    }


}
