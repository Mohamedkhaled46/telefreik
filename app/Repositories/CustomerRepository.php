<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerOTP;
use App\Repositories\Interfaces\ICustomerRepository;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements ICustomerRepository
{
    public $customer;
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function filter()
    {
        $customer = $this->customer->query();
        $customer->when(request()->has('name') && !request()->has('status'), function ($query) {
            return $query->where('name', 'Like', '%' . request('name') . '%');
        });
        $customer->when(request()->has('status') && !request()->has('name'), function ($query) {
            return $query->where('status', request('status'));
        });

        $customer->when(request()->has('name') && request()->has('status'), function ($query) {
            return $query->where('name', 'Like', '%' . request('name') . '%')
                ->where('status', request('status'));
        });
        return $customer->paginate(10);
    }

    public function show($id)
    {
        return $this->customer->where('id', $id)->with('creditCards')->first();
    }

    public function changeStatus($request, $id)
    {
        $status = $request->has('status') ? $request->status : null;
        $customer = Customer::findOrFail($id);
        $isChanged = $customer->update(['status' => $status]);
        return ((bool)$isChanged) ? $customer->refresh() : false;
    }


    public function updateFireBaseToken($id, $newFirebaseToken)
    {
        $customer = $this->findCustomerById($id);
        $customer->customerDetails()->update([
            'firebase_token' => $newFirebaseToken,
        ]);
    }

    public function findCustomerById($id)
    {
        return Customer::find($id);
    }

    public function deleteOldApiTokenById($id)
    {
        DB::table('oauth_access_tokens')->where('user_id', $id)->where('name', 'customer')->delete();
    }

    public function showForMobile($id)
    {
        return $this->customer->where('id', $id)->with('country')->first();
    }

    public function updateCustomerNonMobForMobile($request)
    {
        $id = $request->user('customer-api')->id;
        $this->findCustomerById($id)->update($request->all());
        return $this->findCustomerById($id);
    }

    public function updateCustomerMobForMobile($request)
    {
        $id = $request->user('customer-api')->id;
        $this->findCustomerById($id)->update($request->all());
        return $this->findCustomerById($id);
    }

    public function getCustomersFirebaseTokenByIds($ids)
    {
        return Customer::whereIn('id', $ids)->with('customerDetails')->pluck('firebase_token');
    }

    public function resendOTP($request, $customer)
    {
        $customer->load('latestOTPToken');
        $customer->OTP = randomCode(4, 1);
        $message = trans("OTP Code", ['code' => $customer->OTP]);
        if ($customer->latestOTPToken == null) {
            $sms = sendSMS($message, $customer->mobile);
            if ($sms['sms'] && $sms['smsapi']) {
                CustomerOTP::create([
                    'customer_id' => $customer->id,
                    'code' =>  $customer->OTP,
                ]);
                $customer->smsSent = true;
                $customer->unsetRelation('latestOTPToken');
                return sendResponse($customer, $message);
            } else {
                return sendError('SMS Failed', ['error' => 'SMS Failed']);
            }
        } else {
            if ($customer->latestOTPToken->isValid()) {
                $customer->OTP = $customer->latestOTPToken->code;
                $message = trans("OTP Code", ['code' => $customer->OTP]);
                $customer->smsSent = false;
                $customer->unsetRelation('latestOTPToken');
                return sendResponse($customer, $message);
            }
            $sms = sendSMS($message, $customer->mobile);
            if ($sms['sms'] && $sms['smsapi']) {
                CustomerOTP::create([
                    'customer_id' => $customer->id,
                    'code' =>  $customer->OTP,
                ]);
                $customer->smsSent = true;
                $customer->unsetRelation('latestOTPToken');
                return sendResponse($customer, $message);
            } else {
                return sendError('SMS Failed', ['error' => 'SMS Failed']);
            }
        }
    }

    public function verifyOTP($request, $customer)
    {
        $customer->load('latestOTPToken');
        if ($customer->latestOTPToken == null)
            return sendError('No OTP Generated for this Customer.', ['error' => 'No OTP Generated for this Customer']);
        if ($customer->latestOTPToken->isValid()) {
            if ($request->code == $customer->latestOTPToken->code) {
                $customer->latestOTPToken->used = true;
                $customer->latestOTPToken->save();
                $customer->unsetRelation('latestOTPToken');
                $customer->token = $customer->createToken('customer', ['customer'])->accessToken;

                return sendResponse($customer, 'OTP Verified Successfully.');
            } else {
                return sendError('Code Not Matched', ['error' => 'Code Not Matched']);
            }
        } else {
            return sendError('Code Expired', ['error' => 'Code Expired']);
        }
    }
}
