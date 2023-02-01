<?php


namespace App\Services;

use App\Models\GlobalSetting;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class FeatureService
{

    public function list(): Collection
    {
        return Feature::query()->get();
    }

    public function create($featureData): Feature
    {
        $row = new Feature();

        foreach ($featureData as $key => $value) {
            $row->$key = $this->getRequestValue($key, $row);
        }

        $row->save();

        return $row;

    }

    public function update($featureData, $row)
    {
        foreach ($featureData as $key => $value) {
            $row->$key = $this->getRequestValue($key, $row);
        }

        $row->save();

        return $row;
    }

    protected function getRequestValue($key, $row)
    {


        if (request()->hasFile($key)) {
            ($row->$key != null) ? UploadService::deleteFile(str_replace(Storage::url(''), '', $row->$key)) : null;
            $path = UploadService::uploadFile(request(), $key, GlobalSetting::$uploads_path);
            return Storage::url($path);
        }

        return request()->input($key);
    }


}
