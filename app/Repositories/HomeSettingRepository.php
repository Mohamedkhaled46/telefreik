<?php


namespace App\Repositories;


use App\Models\HomeSetting;
use App\Repositories\Interfaces\IHomeSettingRepository;

class HomeSettingRepository implements IHomeSettingRepository
{
  public function show()
  {
    return HomeSetting::all()->except(20);
  }

  public function update($key, $value)
  {
    $row =  HomeSetting::where('key', $key)->first();
    $row->value = $value;
    $row->save();
  }
}
