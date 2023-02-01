<?php


namespace App\Repositories\Interfaces;


interface IProviderRepository
{
    public function filter();
    public function show($id);
    public function delete($provider);
    public function active($id);
}
