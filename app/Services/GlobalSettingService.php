<?php


namespace App\Services;

use App\Repositories\Interfaces\IGlobalSettingRepository;
use Illuminate\Http\Request;

class GlobalSettingService
{
    public $GlobalSettingRepository ;
    public function __construct(IGlobalSettingRepository $GlobalSettingRepository)
    {
        $this->GlobalSettingRepository  = $GlobalSettingRepository;
    }

    public function show()
    {
       return  $this->GlobalSettingRepository->show();
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $key=>$value)
        {
            $this->GlobalSettingRepository->update($key,$value);
        }
        return true;
    }

    public function showTermsAndConditions()
    {
        return $this->GlobalSettingRepository->showTermsAndConditions();
    }

    public function updateTermsAndConditions(Request $request)
    {
        $this->GlobalSettingRepository->updateTermsAndConditions($request);
        return true;
    }
}
