<?php

namespace App\Services;

use App\Http\Resources\Api\Tazcara\TazcaraResource;
use App\Http\Resources\Api\Tazcara\TazcaraTrips;
use App\Models\Location;

class TazcaraService
{
    private $boardingId,$accessId ,$token, $locations, $searchTrips, $createOrder, $availableSeats;

    public function __construct()
    {
        $this->token = config('providores.BLUE_BUS_KEY');
        $this->locations = config('providores.TAZCARA_LOCATION');
        $this->searchTrips = config('providores.TAZCARA_SEARCH_TRIP');
        $this->createOrder = config('providores.BLUE_BUS_CREATE_ORDER');
        $this->availableSeats = config('providores.BLUE_BUS_AVAILABLE_SEATS');
    }

    public function getLocations()
    {
        $method = 'GET';
        $url = $this->locations;
        return asyncGetRequest($url,$this->token);
    }
    public function generateHash($fromCity,$toCity,$travelDate)
    {
        $accessHash = "V1RmFlSCtqZVAwNEVWczh";
        $accessId = 4;
        $timeStamp = "08102020";
        return hash('sha256', $accessHash.
            $accessId .$timeStamp.$fromCity.
            $toCity.$travelDate);
    }
    public function transformResponse($response)
    {
        $tazcaraLocations = json_decode($response, true)['data'];

        return resourceToArray( TazcaraResource::class, $tazcaraLocations);
    }
    public function transformTrips($response)
    {
         $tazcaraTrips = json_decode($response, true)['data']['trips'];

        return resourceToArray( TazcaraTrips::class, $tazcaraTrips);
    }
    public function searchTrip($data)
    {
        $method = 'GET';
        $url = $this->searchTrips;
        $data['from_location_id'] =  Location::where("id", $data['from_location_id'])->first()->tazcara_id;
        $data['to_location_id'] =  Location::where("id", $data['to_location_id'])->first()->tazcara_id;
        if(empty($data['from_location_id']) || empty($data['to_location_id'])){
            return null;
        }

        $newData = [];

        $newData['from'] = $data['from_location_id'];
        $newData['to'] = $data['to_location_id'];
        $newData['accessId'] = 4;
        $newData['boarding_id'] = 1844;
        $newData['date'] = $data['travel_date'];
        $newData['company'] = "All";
        $newData['number_of_seats'] = 1;
        $newData['round'] = 1;
        $newData['backdate'] = 0;
        $newData['timeStamp'] = "08102020";
        $newData['accessCode'] = $this->generateHash($newData['from'],$newData['to'],$newData['date']);
//        hash('sha256', $accessHash.$accessId .$timeStamp.$fromCity.$toCity.$travelDate)
//        $data=[];
        foreach ($newData as $key => $value){
            $url = str_replace(":".$key,$value,$url);
        }
//        return $url;
        return asyncGetRequest($url);

    }

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
        return  $response;

    }


}
