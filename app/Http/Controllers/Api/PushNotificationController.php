<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PushNotificationRequest;
use App\Http\Requests\UpdateNotificationsReadRequest;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{

    /**
     * @var PushNotificationService
     */
    public $pushNotificationService;

    public function __construct(PushNotificationService $pushNotificationService) {
        $this->pushNotificationService = $pushNotificationService;
    }

    public function sendPushNotification(PushNotificationRequest $request)
    {
        return $this->pushNotificationService->sendPushNotification($request);
    }

    public function showNotificationsPerCustomerForMobile(Request $request)
    {
        $id = $request->user('customer-api')->id;
        $notifications = $this->customerService->showNotificationsPerCustomerForMobile($id);
        if ($notifications == null ) {
            return sendError('Notifications Not Found.', ['error' => 'Notifications Not Found']);
        } else {
            return sendResponse($notifications, 'Notifications Showed successfully.');
        }
    }

    public function updateReadStatusForMobile(UpdateNotificationsReadRequest $request)
    {
        $notification = $this->customerService->updateReadStatusForMobile($request);
        if ($notification == 0 ) {
            return sendError('Notifications Not Found.', ['error' => 'Notifications Not Found']);
        } else {
            return sendResponse($notification, 'Notifications Showed successfully.');
        }
    }

}
