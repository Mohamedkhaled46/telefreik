<?php


namespace App\Services;

use App\Models\GlobalSetting;
use App\Models\Number;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class NumberService
{

    public function list(): Collection
    {
        return Number::query()->get();
    }

    public function create($numberData): Number
    {
        $row = new Number();
        foreach ($numberData as $key => $value) {
            $row->$key = $this->getRequestValue($key, $row);
        }
        $row->save();
        return $row;
    }

    public function update($numberData, $row)
    {
        foreach ($numberData as $key => $value) {
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
