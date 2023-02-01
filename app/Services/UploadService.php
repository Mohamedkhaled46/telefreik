<?php

namespace App\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public static function uploadFile(Request $request, $key, $thePath)
    {
        $path = $request->file($key)->store($thePath);
        return basename($path);
    }

    public static function uploadMultipleFiles(Request $request, $key, $thePath)
    {
        foreach ($request->file($key) as $requestedFile) {
            UploadService::uploadFile($requestedFile, $key, $thePath);
        }
    }

    public static function getFile($fileName)
    {
        $url = Storage::disk(env('FILESYSTEM_DRIVER'))->url($fileName);
        return $url;
    }

    public static function getMultipleFiles(array $filesNames)
    {
        $urls = array();
        foreach ($filesNames as $fileName) {
            $urls[] = UploadService::getFile($fileName);
        }
        return $urls;
    }

    public static function deleteFile($fileName)
    {
        Storage::disk(env('FILESYSTEM_DRIVER'))->delete($fileName);
    }

    public static function deleteMultipleFiles(array $filesNames)
    {
        Storage::disk(env('FILESYSTEM_DRIVER'))->delete($filesNames);
    }
}
