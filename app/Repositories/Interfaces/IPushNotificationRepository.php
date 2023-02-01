<?php


namespace App\Repositories\Interfaces;


interface IPushNotificationRepository
{
    public function create($request);
    public function showNotificationsPerCustomer($id);
    // public function updateReadStatus($request);
    public function updateReadStatusForMobile($request);
}
