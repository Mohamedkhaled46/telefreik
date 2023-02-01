<?php


namespace App\Repositories\Interfaces;


interface ITicketRepository
{

    public function filter();
    public function show($id);
    public function create($request);
    public function getAllForCustomer($request);

}
