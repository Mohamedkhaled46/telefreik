<?php


namespace App\Repositories\Interfaces;


interface IUserRepository
{
    public function all($request);
    public function create($data);
    public function showUser($id);
    public function destroyUser($id);
    public function updateUser($request,$id);
    public function findUser($id);

    public function filter($request);
}
