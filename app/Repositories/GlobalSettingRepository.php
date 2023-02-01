<?php


namespace App\Repositories;


use App\Models\GlobalSetting;
use App\Models\HomeSetting;
use App\Repositories\Interfaces\IGlobalSettingRepository;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class GlobalSettingRepository implements IGlobalSettingRepository
{

    public function show()
    {
       return GlobalSetting::query()
           ->when(request()->input('keys'),function (Builder $q){
               $q->whereIn('key',request()->input('keys'));
           })
           ->get()
           ->except(20);
    }

    public function update($key, $value)
    {
      $row =  GlobalSetting::query()->firstOrCreate(['key'=>$key]);
      $row->value = $this->getRequestValue($key,$row);
      $row->save();
    }

    protected function getRequestValue($key,$row){


        if (request()->hasFile($key)){
            ($row->value != null)?UploadService::deleteFile(str_replace(Storage::url(''),'',$row->value)):null;
            $path = UploadService::uploadFile(request(),$key,GlobalSetting::$uploads_path);
            return Storage::url($path);
        }

        return request()->input($key);
    }

    public function showTermsAndConditions()
    {
        return GlobalSetting::where('key','terms_and_conditions')->first();
    }

    public function updateTermsAndConditions($request)
    {
        $terms =   GlobalSetting::where('key','terms_and_conditions')->first();
        $terms->value = $request->terms_and_conditions;
        $terms->save();
    }
}
