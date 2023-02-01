<?php


namespace App\Repositories\Interfaces;


interface IFaqRepository
{

    public function filter();
    public function create($data);


}
