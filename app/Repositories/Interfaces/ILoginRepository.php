<?php


namespace App\Repositories\Interfaces;


interface ILoginRepository
{
    public function getAuthedUser();
    public function getAuthedCustomer();

    public function logoutMobile($request);
}
