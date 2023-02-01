<?php


namespace App\Repositories;


use App\Models\Customer;
use App\Models\CustomerDetails;
use App\Repositories\Interfaces\IRegisterRepository;

class RegisterRepository implements IRegisterRepository
{
    public function createCustomer($request, $country_id, $isSocial = 0)
    {
        if ($isSocial) {
            $customer = Customer::where('email', $request->email)->orWhere('mobile', $request->mobile)->orWhere('SUUID', $request->SUUID)->first();
            if ($customer != null) {
                $customer->load('customerDetails');
                $customer->email = $request->email;
                $customer->mobile = $request->mobile;
                $customer->name = $request->name;
                $customer->country_id = $country_id;
                $customer->loggedBy = $request->loggedBy;
                $customer->SUUID = $request->SUUID;
                $customer->image = $request->filled('image') ? $request->image : $customer->image;
                $customer->save();
                $customer->customerDetails->firebase_token = $request->firebase_token;
                $customer->customerDetails->os_system = $request->os_system;
                $customer->customerDetails->os_version = $request->os_version;
                $customer->customerDetails->save();
                $customer->refresh();
                return $customer;
            }
        }
        $customer = Customer::create(
            [
                'email' => $request->email,
                'mobile' => $request->mobile,
                'name' => $request->name,
                'SUUID' => $isSocial ? $request->SUUID : null,
                'loggedBy' => $isSocial ? $request->loggedBy : 'default',
                'image' => ($isSocial && $request->filled('image')) ? $request->image : null,
                'country_id' => $country_id
            ]
        );
        CustomerDetails::create(
            [
                'firebase_token' => $request->firebase_token,
                'os_system' => $request->os_system,
                'os_version' => $request->os_version,
                'customer_id' => $customer->id,
            ]
        );

        return $customer;
    }
}
