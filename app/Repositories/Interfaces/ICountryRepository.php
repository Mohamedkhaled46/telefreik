<?php


namespace App\Repositories\Interfaces;


interface ICountryRepository
{
    public function getIdByPhoneCode($phonecode);
}
