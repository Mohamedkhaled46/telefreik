<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\BlueBusService;
use App\Services\LocationService;
use App\Services\TripService;
use App\Services\WeBusService;
use Illuminate\Http\Request;

class TripApiController extends Controller
{
    private $blueBusService;
    private $weBusService;

    public function __construct(TripService $tripService ,BlueBusService $blueBusService, WeBusService $weBusService,LocationService $locationService)
    {
        $this->tripService = $tripService;
        $this->blueBusService = $blueBusService;
        $this->weBusService = $weBusService;
        $this->locationService = $locationService;
    }
    public function getTripsLocations($sync =false)
    {


        try {
            if($sync == "sync"){
                $this->tripService->getLocations();
            }
        }catch (\Exception $e){
            //return response()->json(['message' => $e->getMessage()], 500);
        }


        if($sync != "sync") {

            return response($this->locationService->get(), 200);
        }else{
            return response(["success"=>true], 200);

        }
    }

    public function getWeBusLocations()
    {
        return $this->weBusService->getLocations();
    }

    public function searchTrip(Request $request,$sync="")
    {

        $this->validate($request, [
            'from_location_id' => 'required|exists:locations,id',
            'to_location_id' => 'required|exists:locations,id',
            'travel_date' => 'required|date',
        ]);
        $data = $request->only(['from_location_id', 'to_location_id', 'travel_date']);
        return $this->tripService->searchTrip($data,$sync);
    }
    public function searchTripWeBusMain(Request $request)
    {
        $this->validate($request, [
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            'travel_date' => 'required',
        ]);

        $data = [
            'from' => $request->from_location_id,
            'to' => $request->to_location_id,
            'date' => $request->travel_date,
        ];


        return $this->weBusService->searchTrip($data);
    }

    public function searchTripWeBus(Request $request)
    {
        $this->validate($request, [
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            'travel_date' => 'required',
        ]);

        $data = [
            'from' => $request->from_location_id,
            'to' => $request->to_location_id,
            'date' => $request->travel_date,
        ];


        return $this->weBusService->searchTrip($data);
    }

    public function availableSeats(Request $request)
    {
        $this->validate($request, [
            'trip_id' => 'required',
            'from_location_id' => 'required',
            'to_location_id' => 'required',
        ]);
        $data = $request->only(['trip_id', 'from_location_id', 'to_location_id']);
        return $this->blueBusService->availableSeats($data);
    }

    public function createOrder(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required',
            'tickets' => 'required',

        ]);
        $data = $request->only(['customer', 'tickets']);
        return $this->blueBusService->createOrder($data);
    }
}
