<?php


namespace App\Repositories;


use App\Models\Country;

class CountryRepository implements Interfaces\ICountryRepository
{

    public function getIdByPhoneCode($phonecode)
    {
      return Country::where('phonecode',$phonecode)->first(['id'])->id;
    }
}
