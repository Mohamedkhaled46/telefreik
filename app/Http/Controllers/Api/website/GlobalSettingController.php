<?php

namespace App\Http\Controllers\Api\website;

use App\Http\Controllers\Controller;
use App\Services\GlobalSettingService;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public $globalSettingService;

    public function __construct(GlobalSettingService $globalSettingService)
    {
        $this->globalSettingService = $globalSettingService;
    }
    public function show()
    {
        $global_setting =  $this->globalSettingService->show();
        return  sendResponse($global_setting,'Global Setting Retrieved Successfully');

    }

    public function update(Request $request)
    {
        $data = $this->globalSettingService->update($request);
        if ($data)
        {
            return  sendResponse([],'Global Setting Saved Successfully');
        }
    }

    public function showTermsAndConditions()
    {
        $global_setting =  $this->globalSettingService->showTermsAndConditions();
        return  sendResponse($global_setting,'Terms And Conditions Retrieved Successfully');
    }

    public function updateTermsAndConditions(Request $request)
    {
        $data = $this->globalSettingService->updateTermsAndConditions($request);
        if ($data)
        {
            return  sendResponse([],'Terms And Conditions Saved Successfully');
        }
    }
}
