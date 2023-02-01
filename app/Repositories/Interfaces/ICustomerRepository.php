<?php


namespace App\Repositories\Interfaces;


interface ICustomerRepository
{
    public function filter();
    public function show($id);
    public function findCustomerById($id);
    public function updateFireBaseToken($id, $newFirebaseToken);

    public function deleteOldApiTokenById($id);
    public function showForMobile($id);
    public function updateCustomerNonMobForMobile($request);

    public function getCustomersFirebaseTokenByIds($ids);

    public function changeStatus($request, $id);

    public function resendOTP($request, $customer);
    public function verifyOTP($request, $customer);
}
