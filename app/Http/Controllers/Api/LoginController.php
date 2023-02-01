<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginMobileRequest;
use App\Http\Requests\LogoutMobileRequest;
use App\Http\Requests\RefreshFireBaseTokenRequest;
use App\Services\LoginService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginDashboardRequest;
use App\Http\Controllers\Api\BaseController as BaseController;

class LoginController extends BaseController
{
    public $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }


    public function loginDashBoard(LoginDashboardRequest $request)
    {

        $user = $this->loginService->loginDashBoard($request);
        if (count($user) == 0) {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        } else {
            return $this->sendResponse($user, 'User login successfully.');
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $response = $this->loginService->forgotPassword($request);
        if ($response) {
            return $this->sendResponse('', 'Reset Link successfully Sent To Your Email.');
        } else {
            return $this->sendError('Your Email Is Not Registered In Our Website .', [], 400);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $response = $this->loginService->resetPassword($request);
        if ($response) {
            return $this->sendResponse('', 'Password has been successfully changed.');
        } else {
            return $this->sendError('Invalid token provided .', [], 400);
        }
    }
    public function loginMobile(LoginMobileRequest $request)
    {

        $customer = $this->loginService->loginMobile($request);
        if (count($customer) == 0) {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized'],401);
        } else {
            return $this->sendResponse($customer, 'User login successfully.');
        }
    }

    public function logoutMobile(LogoutMobileRequest $request)
    {
        $customer = $this->loginService->logoutMobile($request);
        if (count($customer) == 0) {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        } else {
            return $this->sendResponse($customer, 'User logged out successfully.');
        }
    }

    public function refreshFirebaseToken(RefreshFireBaseTokenRequest $request)
    {
        $customer = $this->loginService->refreshFirebaseToken($request);
        if (count($customer) == 0) {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        } else {
            return $this->sendResponse($customer, 'User login successfully.');
        }
    }
}
