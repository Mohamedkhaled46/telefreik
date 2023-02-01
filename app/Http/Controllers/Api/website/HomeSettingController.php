<?php

namespace App\Http\Controllers\Api\website;

use App\Http\Controllers\Controller;
use App\Services\GlobalSettingService;
use App\Services\HomeSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeSettingController extends Controller
{
    public $homeSettingService;

    public function __construct(HomeSettingService $homeSettingService)
    {
        $this->homeSettingService = $homeSettingService;
    }
    public function show(): JsonResponse
    {
        $home_setting =  $this->homeSettingService->show();
        return  sendResponse($home_setting,'Home Setting Retrieved Successfully');

    }

    public function update(Request $request)
    {
        $data = $this->homeSettingService->update($request);
        if ($data)
        {
            return  sendResponse([],'Global Setting Saved Successfully');
        }
    }



}
