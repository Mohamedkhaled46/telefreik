<?php


namespace App\Repositories;

use App\Repositories\Interfaces\ILoginRepository;
use Illuminate\Support\Facades\Auth;

class LoginRepository implements ILoginRepository
{

    public function getAuthedUser()
    {
        return Auth::User();
    }

    public function getAuthedCustomer()
    {
        return Auth::guard('customer')->user();
    }

    public function logoutMobile($request)
    {
        $request->user()->token()->revoke();
    }
}
