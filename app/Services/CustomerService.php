<?php

namespace App\Services;

use App\Repositories\Interfaces\ICountryRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\ILoginRepository;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Hash;

class CustomerService
{
    public $customerRepository;
    public $loginRepository;
    public $countryRepository;
    public function __construct(ICustomerRepository $customerRepository, ILoginRepository $loginRepository, ICountryRepository $countryRepository)
    {
        $this->customerRepository  = $customerRepository;
        $this->loginRepository  = $loginRepository;
        $this->countryRepository = $countryRepository;
    }


    public function filter()
    {
        return $this->customerRepository->filter();
    }

    public function show($id)
    {
        return $this->customerRepository->show($id);
    }

    public function changeStatus($request, $id)
    {
        return $this->customerRepository->changeStatus($request, $id);
    }

    public function showForMobile($id)
    {
        return $this->customerRepository->showForMobile($id);
    }

    public function updateCustomerNonMobForMobile($request)
    {
        $id = $request->user('customer-api')->id;
        $customer = $this->customerRepository->findCustomerById($id);
        if ($request->has('file')) {
            $request->merge([
                'image' => UploadService::uploadFile($request, 'file', 'customers_images')
            ]);
            UploadService::deleteFile($customer->image);
        }
        return $this->customerRepository->updateCustomerNonMobForMobile($request);
    }

    public function updateCustomerMobForMobile($request)
    {
        $id = $request->user('customer-api')->id;
        $idOfPhoneCode = $this->countryRepository->getIdByPhoneCode($request->phonecode);
        $request->merge(['country_id' => $idOfPhoneCode]);
        $newFirebaseToken = $request->new_firebase_token;
        $this->customerRepository->updateFireBaseToken($id, $newFirebaseToken);
        $this->customerRepository->deleteOldApiTokenById($id);
        $customer = $this->customerRepository->updateCustomerMobForMobile($request);
        Auth::guard('customer')->login($customer); //logged in
        $customer = $this->loginRepository->getAuthedCustomer();
        $customer['token'] = $customer->createToken('customer', ['customer'])->accessToken;
        return $customer;
    }

    public function resendOTP($request)
    {
        $id = $request->user('customer-api')->id;
        $customer = $this->customerRepository->findCustomerById($id);
        if ($customer == null)
            return sendError('Customer Not Found', ['error' => 'Customer Not Found']);
        return $this->customerRepository->resendOTP($request, $customer);
    }

    public function verifyOTP($request)
    {
        $id = $request->user('customer-api')->id;
        $customer = $this->customerRepository->findCustomerById($id);
        if ($customer == null)
            return sendError('Customer Not Found', ['error' => 'Customer Not Found']);
        return $this->customerRepository->verifyOTP($request, $customer);
    }
}
