<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\RegisterMobileRequest;
use App\Services\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    public $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function registerMobile(RegisterMobileRequest $request)
    {
        $customer = $this->registerService->registerMobile($request);
        return $this->sendResponse($customer, 'Users Created successfully.');
    }
}
