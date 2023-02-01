<?php


namespace App\Services;

use App\Models\GlobalSetting;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class SubscriptionService
{

    public function list(): Collection
    {
        return Subscription::query()->get();
    }

    public function create($subscriptionData): Subscription
    {
        $row = new Subscription();
        foreach ($subscriptionData as $key => $value) {
            $row->$key = $this->getRequestValue($key, $row);
        }
        $row->save();
        return $row;
    }

    public function update($subscriptionData, $row)
    {
        foreach ($subscriptionData as $key => $value) {
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
