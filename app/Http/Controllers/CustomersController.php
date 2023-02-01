<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCustomerMobForMobileRequest;
use App\Http\Requests\UpdateCustomerNonMobForMobileRequest;
use App\Http\Requests\UpdateStatusCustomer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response($this->customerService->filter(), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response($this->customerService->show($id), 200);
    }


    public function changeStatus(UpdateStatusCustomer $request ,$id)
    {
        return response($this->customerService->changeStatus($request , $id), 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showForMobile(Request $request)
    {
        $id = $request->user('customer-api')->id;
       $customer = $this->customerService->showForMobile($id);
        if ($customer == null ) {
            return sendError('Customer Not Found.', ['error' => 'Customer Not Found']);
        } else {
            return sendResponse($customer, 'Customer Showed successfully.');
        }
    }

    public function updateCustomerNonMobForMobile(UpdateCustomerNonMobForMobileRequest $request)
    {
        $customer = $this->customerService->updateCustomerNonMobForMobile($request);
        return sendResponse($customer, 'Customer Updated successfully.');
    }

    public function updateCustomerMobForMobile(UpdateCustomerMobForMobileRequest $request)
    {
        $customer = $this->customerService->updateCustomerMobForMobile($request);
        return sendResponse($customer, 'Customer Mobile Updated successfully.');
    }
}
