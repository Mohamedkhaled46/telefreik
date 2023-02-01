<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Services\ProviderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProvidersController extends Controller
{
    protected $providerService;
    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response($this->providerService->filter(), 200);
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
        return response($this->providerService->show($id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( $id)
    {
        $provider = $this->providerService->active($id);
        return ($provider) ? response(["message" => "provider is active successfully", "provider" => $provider], 200) : response($provider, 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $isDeleted = $this->providerService->delete($provider);
        return ($isDeleted) ? response(["message" => "provider is disabled successfully", "provider" => $provider], 200) : response(["message" => "oops , something  wrong  please try again ", "provider" => $provider], 500);
    }
}
