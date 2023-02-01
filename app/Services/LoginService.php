<?php


namespace App\Services;


use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerOTP;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IRegisterRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Repositories\Interfaces\ILoginRepository;

class LoginService
{
    public $loginRepository;
    public $customerRepository;
    public $registerService;

    public function __construct(ILoginRepository $loginRepository, ICustomerRepository $customerRepository, RegisterService $registerService)
    {
        $this->loginRepository = $loginRepository;
        $this->customerRepository = $customerRepository;
        $this->registerService = $registerService;
    }

    public function loginDashBoard($request)
    {
        $success = [];
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $this->loginRepository->getAuthedUser();
            $success['token'] = $user->createToken('telefreik')->accessToken;
            $success['name'] = $user->name;
            $success['role'] = $user->role->name;
            $success['user_image'] = $user->user_image;
        }
        return $success;
    }

    public function forgotPassword($request)
    {
        $sentUrl = Password::sendResetLink(
            $request->only('email')
        );

        if ($sentUrl == Password::RESET_LINK_SENT) {
            return true;
        } elseif ($sentUrl == Password::INVALID_USER) {
            return false;
        }
    }

    public function resetPassword($request)
    {
        $urlWithToken = Password::reset($request->only(['token', 'email', 'password', 'password_confirmation']), function ($user, $password) use ($request) {
            $user->forceFill([
                'password' => Hash::make($password)
            ]);
            $user->save();
        });

        if ($urlWithToken == Password::INVALID_TOKEN) {
            return false;
        } else {
            return true;
        }
    }

    public function loginMobile($request)
    {
        $success = [];

        $customer = Customer::query()
            ->where('mobile', $request->mobile)
            ->whereHas('country', function ($q) use ($request) {
                $q->where('phonecode', $request->phonecode);
            })->first();
        // $country = Country::query()->where('phonecode', $request->phonecode)->firstOrFail();

        // if ($country->id == 63) {
        //     if (substr($request->mobile, 0, 2) !== '01') {
        //         $request->merge(['mobile' => "0{$request->mobile}"]);
        //     }
        // }
        // if ($customer) {
        if ($customer != null) {
            Auth::guard('customer')->login($customer); //logged in
            $customer = $this->loginRepository->getAuthedCustomer();

            $customer->load('latestOTPToken');

            $customer->OTP = randomCode(4, 1);
            $message = trans("OTP Code", ['code' => $customer->OTP]);
            $smsSent = false;

            if ($customer->latestOTPToken == null) {

//                $sms = sendSMS($message, $customer->mobile);
//                if ($sms['sms'] && $sms['smsapi']) {

                    CustomerOTP::create([
                        'customer_id' => $customer->id,
                        'code' =>  $customer->OTP,
                    ]);
                    $smsSent = true;
//                }
            } else {
                if ($customer->latestOTPToken->isValid()) {
                    $customer->OTP = $customer->latestOTPToken->code;
                }
//                $sms = sendSMS($message, $customer->mobile);
//                if ($sms['sms'] && $sms['smsapi']) {
                    CustomerOTP::create([
                        'customer_id' => $customer->id,
                        'code' =>  $customer->OTP,
                    ]);
                    $smsSent = true;
//                }
            }

//            $success['token'] = $customer->createToken('customer', ['customer'])->accessToken;
            $success['smsSent'] = $smsSent;
        }
        //  else {
        //     return $this->registerService->registerMobile($request);
        // }
        return $success;
    }

    public function logoutMobile($request)
    {
        $success = [];
        $customer = Customer::where('mobile', $request->mobile)->whereHas('country', function ($q) use ($request) {
            $q->where('phonecode', $request->phonecode);
        })->first();
        if ($customer != null) {
            $success['mobile'] = $customer->country->phonecode . $customer->mobile;
            $this->loginRepository->logoutMobile($request);
        }
        return $success;
    }

    public function refreshFirebaseToken($request)
    {
        $id = $request->user('customer-api')->id;
        $newFirebaseToken = $request->new_firebase_token;
        $this->customerRepository->updateFireBaseToken($id, $newFirebaseToken);
        $this->customerRepository->deleteOldApiTokenById($id);

        return $this->loginMobile($request);
    }
}
