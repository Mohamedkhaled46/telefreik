<?php


namespace App\Repositories;


use App\Models\Pnotification;
use App\Repositories\Interfaces\IPushNotificationRepository;

class PushNotificationRepository implements IPushNotificationRepository
{
    public $pushNotification;
    public function __construct(Pnotification $pushNotification)
    {
        $this->pushNotification = $pushNotification;
    }

    public function create($request)
    {
        foreach ($request->customers_ids as $customer_id) {
            Pnotification::create([
                'customer_id' => $customer_id,
                'pnotification_type_id' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
            ]);
        }
    }

    public function showNotificationsPerCustomer($id)
    {
        return Pnotification::where('customer_id', $id)->get();
    }

    public function updateReadStatusForMobile($request)
    {
        return Pnotification::where('id', $request->notification_id)->update(['read' => $request->notification_read]);
    }

    // public function updateReadStatus($request)
    // {
    //    return Pnotification::where('id',$request->notification_id)->update(['read'=>$request->notification_read]);
    // }
}
