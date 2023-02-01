<?php


namespace App\Services;

use App\Models\AboutCards;
use App\Models\GlobalSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class AboutCardService
{

    public function list(): Collection
    {
        return AboutCards::query()->get();
    }

    public function create($cardData): AboutCards
    {
        $row = new AboutCards();

        foreach ($cardData as $key => $value) {
            $row->$key = $this->getRequestValue($key, $row);
        }

        $row->save();

        return $row;

    }

    public function update($cardData, $row)
    {
        foreach ($cardData as $key => $value) {
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
