<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $data = $this->userService->GetAllUsers($request);
        return $this->sendResponse($data, 'Users Loaded successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
            $data =  $this->userService->createUser($request);
            return $this->sendResponse($data, 'Users Created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->userService->getUser($id);
        if($data==null)
        {
            return $this->sendError('User Not Found.', ['error'=>'User Not Found']);
        }
        else
        {
                return $this->sendResponse($data, 'User Loaded successfully.');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $this->userService->updateUser($request,$id);
        return $this->sendResponse($data, 'Users Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->userService->destroyUser($id);
        if(!$data)
        {
            return $this->sendError('User Not Found.', ['error'=>'User Not Found']);
        }
        return $this->sendResponse($data, 'User Deleted successfully.');
    }

}
