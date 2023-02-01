<?php


namespace App\Services;

use App\Models\HomeSetting;
use Illuminate\Http\Request;
use App\Services\UploadService;
use App\Repositories\Interfaces\IHomeSettingRepository;

class HomeSettingService
{
    public $homeSettingRepository ;
    public function __construct(IHomeSettingRepository $homeSettingRepository)
    {
        $this->homeSettingRepository  = $homeSettingRepository;
    }

    public function show()
    {
        return  $this->homeSettingRepository->show();
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        foreach ( $data as $key=>$value)
        {
            if(in_array($key,['about_image' ,'welcome_image']))
            {
                switch ($key) {
                    case 'about_image':
                         $home = HomeSetting::where('key','about_image')->first();
                         ($home->value != null)?UploadService::deleteFile($home->value):null;
                         $path = UploadService::uploadFile($request,'about_image','home_setting/about');
                         $value = $path;
                    break;
                    case 'welcome_image':
                        $home = HomeSetting::where('key','welcome_image')->first();
                        ($home->value != null)?UploadService::deleteFile($home->value):null;
                        $path = UploadService::uploadFile($request,'welcome_image','home_setting/welcome');
                        $value = $path;
                    break;
                }
            }
            $this->homeSettingRepository->update($key,$value);
        }
        return true;
    }



}
