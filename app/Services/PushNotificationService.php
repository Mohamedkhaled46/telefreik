<?php


namespace App\Services;


use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IPushNotificationRepository;

class PushNotificationService
{
    public $pushNotificationRepository;
    public $customerRepository;
    public function __construct(IPushNotificationRepository $pushNotificationRepository, ICustomerRepository $customerRepository)
    {
        $this->pushNotificationRepository  = $pushNotificationRepository;
        $this->customerRepository  = $customerRepository;
    }


    public function sendPushNotification($request)
    {
        $firebaseTokens = $this->customerRepository->getCustomersFirebaseTokenByIds($request->customers_ids);
        $response = $this->sendNotification($firebaseTokens, array(
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'type' => $request->type
        ));
        // $this->pushNotificationRepository->create($request);
        $results = json_decode($response)->results;
        $succeededCustomers = [];
        foreach ($results as $key => $value) {
            if (isset($value->message_id)) {
                array_push($succeededCustomers, $key);
            }
        }
        $customers =  array_filter($request->customers_ids, function ($v, $k) use ($succeededCustomers) {
            if (in_array($k, $succeededCustomers))
                return $v;
        }, ARRAY_FILTER_USE_BOTH);
        if (count($customers) > 0) {
            return   $this->pushNotificationRepository->create($request, $customers);
        } else return $customers;
    }

    // public function sendNotification($device_tokens, $message)
    // {
    //     $SERVER_API_KEY = '<YOUR-SERVER-API-KEY>';

    //     // payload data, it will vary according to requirement
    //     $data = [
    //         "registration_ids" => $device_tokens, // for multiple device ids
    //         "data" => $message
    //     ];
    //     $dataString = json_encode($data);

    //     $headers = [
    //         'Authorization: key=' . $SERVER_API_KEY,
    //         'Content-Type: application/json',
    //     ];

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    //     $response = curl_exec($ch);

    //     curl_close($ch);

    //     return $response;
    // }
    public function sendNotification($device_tokens, $message)
    {
        $SERVER_API_KEY = 'AAAA1V4azdA:APA91bESbMzMK1lmVGYj-2FXsZq7fAIKN2dQFLmXQpAYVy7c27veVh1VQzZmVfXV8HPx2U5a8Rpg0N98DQUB8A96UFy1BazlO0H6lkKjwS2b8jT9GLjS0u80VgEoTfOATUjWtRo5fuUY';

        // payload data, it will vary according to requirement
        $data = [
            "registration_ids" => $device_tokens, // for multiple device ids
            "data" => $message
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            $headers
        );
        curl_setopt(
            $ch,
            CURLOPT_SSL_VERIFYPEER,
            false
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public function showNotificationsPerCustomerForMobile($id)
    {
        return $this->pushNotificationRepository->showNotificationsPerCustomer($id);
    }

    public function updateReadStatusForMobile($request)
    {
        return $this->pushNotificationRepository->updateReadStatusForMobile($request);
    }
}
