<?php


namespace App\Services;



use App\Repositories\Interfaces\ICountryRepository;
use App\Repositories\Interfaces\ILoginRepository;
use App\Repositories\Interfaces\IRegisterRepository;
use Illuminate\Support\Facades\Auth;

class RegisterService
{
    public $registerRepository;
    public $loginRepository;
    public $countryRepository;
    public function __construct(IRegisterRepository $registerRepository, ILoginRepository $loginRepository, ICountryRepository $countryRepository)
    {
        $this->registerRepository  = $registerRepository;
        $this->loginRepository  = $loginRepository;
        $this->countryRepository = $countryRepository;
    }

    public function registerMobile($request)
    {
        $country_id = $this->countryRepository->getIdByPhoneCode($request->phonecode);
        $customer = $this->registerRepository->createCustomer($request, $country_id);
        Auth::guard('customer')->login($customer); //logged in
        $customer = $this->loginRepository->getAuthedCustomer();
        $success['token'] = $customer->createToken('customer', ['customer'])->accessToken;
        $success['id'] = $customer->id;
        $success['name'] = $customer->name;
        $success['status'] = $customer->status;
        $success['mobile'] = $customer->mobile;
        $success['email'] = $customer->email;
        $success['user_image'] = !filter_var($customer->image, FILTER_VALIDATE_URL) ? UploadService::getFile("customers_images/$customer->image") : $customer->image;
        $success['created_at'] = $customer->created_at;
        $success['updated_at'] = $customer->updated_at;
        return $success;
    }

    public function socialRegister($request)
    {
        $country_id = $this->countryRepository->getIdByPhoneCode($request->phonecode);
        $customer = $this->registerRepository->createCustomer($request, $country_id, true);
        Auth::guard('customer')->login($customer); //logged in
        $customer = $this->loginRepository->getAuthedCustomer();
        $success['token'] = $customer->createToken('customer', ['customer'])->accessToken;
        $success['id'] = $customer->id;
        $success['name'] = $customer->name;
        $success['status'] = $customer->status;
        $success['mobile'] = $customer->mobile;
        $success['email'] = $customer->email;
        $success['user_image'] = !filter_var($customer->image, FILTER_VALIDATE_URL) ? UploadService::getFile("customers_images/$customer->image") : $customer->image;
        $success['created_at'] = $customer->created_at;
        $success['updated_at'] = $customer->updated_at;
        return $success;
    }
}
