<?php


namespace App\Repositories\Interfaces;


interface IHomeSettingRepository
{

    public function show();

    public function update($key, $value);

}
