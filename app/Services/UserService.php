<?php

namespace App\Services;

use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public $userRepository;
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository  = $userRepository;
    }

    public function GetAllUsers($request)
    {
        return $this->userRepository->all($request);
    }

    public function createUser($request)
    {
        $request->merge([
            'user_image' => UploadService::uploadFile($request, 'file', 'user_images'),
            'password' => Hash::make($request->password)
        ]);
        return $this->userRepository->create($request->validated());
    }

    public function getUser($id)
    {
        return $this->userRepository->showUser($id);
    }

    public function destroyUser($id)
    {
        return $this->userRepository->destroyUser($id);
    }

    public function updateUser($request, $id)
    {
        $user = $this->userRepository->findUser($id);
        if ($request->filled('password')) {
            $request->merge([
                'password' => Hash::make($request->password)
            ]);
        }
        if ($request->hasFile('file')) {
            $request->merge([
                'user_image' => UploadService::uploadFile($request, 'file', 'user_images')
            ]);
            UploadService::deleteFile($user->user_image);
        }
        return $this->userRepository->updateUser($request->validated(), $id);
    }
}
