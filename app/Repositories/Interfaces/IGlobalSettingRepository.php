<?php


namespace App\Repositories\Interfaces;


interface IGlobalSettingRepository
{

    public function show();

    public function update($key, $value);

    public function showTermsAndConditions();

    public function updateTermsAndConditions($request);
}
