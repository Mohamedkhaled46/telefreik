<?php


namespace App\Repositories\Interfaces;


interface IRegisterRepository
{
    public function createCustomer($request,$country_id,$isSocial);
}
