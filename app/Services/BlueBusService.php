<?php

namespace App\Services;

use App\Http\Resources\Api\BlueBus\BlueBusResource;
use App\Http\Resources\Api\BlueBus\BlueBusTripsResource;
use App\Models\Location;
use GuzzleHttp\Promise\Utils;
class BlueBusService
{
    private $token, $locations, $searchTrips, $createOrder, $availableSeats;

    public function __construct()
    {
        $this->token = config('providores.BLUE_BUS_KEY');
        $this->locations = config('providores.BLUE_BUS_LOCATION');
        $this->searchTrips = config('providores.BLUE_BUS_SEARCH_TRIP');
        $this->createOrder = config('providores.BLUE_BUS_CREATE_ORDER');
        $this->availableSeats = config('providores.BLUE_BUS_AVAILABLE_SEATS');
    }

    public function getLocations()
    {
        $method = 'GET';
        $url = $this->locations;
        return asyncGetRequest($url,$this->token);
    }
    public function transformResponse($response)
    {

        $newArray = [];
        $blueBusLocations = json_decode($response, true)['data']['cities'];
        foreach ($blueBusLocations as $location){
//            dd($location['locations']);
            $internal = $location['locations'];
            unset($location['locations']);
            $newArray[] = $location;
            $newArray = array_merge($newArray, $internal);
        }
//        dd($blueBusLocations);
        return resourceToArray( BlueBusResource::class, $newArray);
    }
    public function locationHandler($locationResponse)
    {
        $url = $this->locations;
        return asyncGetRequest($url,$this->token);
    }

//     public function searchTrip($data)
//     {
//         $method = 'POST';
//         $url = $this->searchTrips;
// //        dd($data,$url);
//         return $this->runLink($url, $method, $data);
//     }

    public function AvailableSeats($data)
    {
        $method = 'POST';
        $url = $this->availableSeats;

        return $this->runLink($url, $method, $data);
    }

    public function createOrder($data)
    {
        $method = 'POST';
        $url = $this->createOrder;

        return $this->runLink($url, $method, $data, true);
    }

    protected function runLink($url, $method = 'POST', $data = [], $json = false)
    {
        $curl = curl_init();

        $header = ['Accept: application/json',
            "Authorization: Bearer {$this->token}",];

        if ($json) {
            $header[] = 'Content-Type: application/json';
            $data = json_encode($data);
        }


        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);


        curl_close($curl);

       /* if ($this->isJson($response)){
            return  $response;
        }*/
        return  $response;

    }

    public function searchTrip($data)
    {
        $url = $this->searchTrips;
        $data['from_location_id'] =Location::find($data['from_location_id'])?->blue_bus_id;
        $data['to_location_id'] =Location::find($data['to_location_id'])?->blue_bus_id;
        return asyncPostRequest($url,$this->token,$data);
    }

    public function transformTrips($response)
    {
         $blueBusTrips = json_decode($response, true)['data'];

        // return $blueBusTrips;
        return resourceToArray( BlueBusTripsResource::class, $blueBusTrips);
    }

}
