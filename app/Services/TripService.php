<?php

namespace App\Services;
use App\Http\Resources\Api\BlueBus\BlueBusResource;
use App\Http\Resources\Api\Tazcara\TazcaraResource;
use App\Http\Resources\Api\WeBus\WeBusResource;
use App\Models\Location;
use App\Models\Trip;
use GuzzleHttp\Promise\Utils;
use DB;

class TripService
{
    public function __construct(BlueBusService $blueBusService, WeBusService $weBusService, TazcaraService  $tazcaraService)
    {
        $this->blueBusService = $blueBusService;
        $this->weBusService = $weBusService;
        $this->tazcaraService = $tazcaraService;

    }
    public function getLocations()
    {
        $blueBusLocations = $this->blueBusService->getLocations();
        $weBusLocations = $this->weBusService->getLocations();
        $tazcaraLocations = $this->tazcaraService->getLocations();
        // Wait for the responses to be received
        $responses = Utils::unwrap([$blueBusLocations,$weBusLocations,$tazcaraLocations]);
//        return $this->tazcaraService->generateHash();
        // Get the body transform of each response
        $blueBusLocations = $this->blueBusService->transformResponse($responses[0]);
        $weBusLocations = $this->weBusService->transformResponse($responses[1]);
        $tazcaraLocations = $this->tazcaraService->transformResponse($responses[2]);


//        return $weBusLocations =  array_values(collect($weBusLocations)->where("internal",1)->toArray());

        $mergedArrays = $this->mergeApis($blueBusLocations,$weBusLocations,$tazcaraLocations);
        DB::transaction(function () use ($mergedArrays) {
            foreach ($mergedArrays as $key => $mergedSubArray) {

                $location = Location::where("name_en",$mergedSubArray["name_en"])->orWhere("name_ar",$mergedSubArray["name_ar"])->first();
                if($location){
                    $location->update($mergedSubArray);
                }else{
                    Location::create($mergedSubArray);
                }
            }
        },2);
        return $mergedArrays;




    }

    public function mergeApis($blueBusLocations,$weBusLocations,$tazcaraLocations)
    {
        $mergedArrays = array();
        foreach (array($tazcaraLocations, $blueBusLocations, $weBusLocations) as $arr) {
            foreach ($arr as $subArray) {
                $found = false;
                foreach ($mergedArrays as $key => $mergedSubArray) {
                    if (isset($subArray['name_en']) && isset($mergedSubArray['name_en']) && mb_strtolower($subArray['name_en']) === mb_strtolower($mergedSubArray['name_en'])) {
                        $mergedArrays[$key] = array_merge($mergedSubArray, $subArray);
                        $found = true;
                        break;
                    }
                    if (isset($subArray['name_ar']) && isset($mergedSubArray['name_ar']) && mb_strtolower($subArray['name_ar']) === mb_strtolower($mergedSubArray['name_ar'])) {
                        $mergedArrays[$key] = array_merge($mergedSubArray, $subArray);
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $mergedArrays[] = $subArray;
                }
            }
        }
        return $mergedArrays;

    }
    public  function checkIfPromiseAvailable($responses,$promise,$responseKey){
        return !($promise == null || ($promise != null && $responses[$responseKey]->getStatusCode() != 200) );

    }
    public function searchTrip($data,$sync)
    {
        $method = 'GET';
        $allData = [] ;
        if($sync == "sync"){

        $tazcaraTrips = $this->tazcaraService->searchTrip($data) ;
        $weBusTrips = $this->weBusService->searchTrip($data) ;
        $blueBusTrips = $this->blueBusService->searchTrip($data) ;
        $promises = array_filter([$tazcaraTrips,$weBusTrips,$blueBusTrips]);

        $responses =  array_values(Utils::unwrap($promises));


        $mergedArrays = [];
        $responseKey = 0;
//        dd($responses);
        if(!empty($responses)){

            if($this->checkIfPromiseAvailable($responses,$tazcaraTrips,$responseKey)){
                try{

                    $tazcaraTransformTrips = $this->tazcaraService->transformTrips($responses[$responseKey]);
                    $responseKey++;
                    $mergedArrays[] = $tazcaraTransformTrips;
                } catch (\Exception $e) {
                    // handle the exception
                }
            }
            if($this->checkIfPromiseAvailable($responses,$weBusTrips,$responseKey)) {

                try {

                    $weBusTransformTrips = $this->weBusService->transformTrips($responses[$responseKey]);
                    $responseKey++;
                    $mergedArrays[] = $weBusTransformTrips;

                } catch (\Exception $e) {
                    // handle the exception
                }
            }
            if($this->checkIfPromiseAvailable($responses,$blueBusTrips,$responseKey)) {
                try {
                    $blueBusTransformTrips = $this->blueBusService->transformTrips($responses[$responseKey]);

                    $mergedArrays[] = $blueBusTransformTrips;

                } catch (\Exception $e) {
                    return $e->getMessage();
                    // handle the exception
                }
            }
            foreach ($mergedArrays as $merge){
                if(empty($merge)){
                    continue;
                }

                Trip::where("from_location_id",request()->from_location_id)->where("to_location_id",request()->to_location_id)
                    ->where("date",request()->travel_date)->where("type",$merge[0]['type'])->delete();
                Trip::insert($merge);
            }
        }
        }

        if($sync !="sync"){
            return Trip::with(["from_location","to_location"])->where("from_location_id",request()->from_location_id)->where("to_location_id",request()->to_location_id)
                ->where("date",request()->travel_date)->paginate(10);

        }else{
            return response()->json([
                'status' => 'success',
                'message' => 'Trips Synced Successfully',
            ], 200);
        }



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

        $header = [
            'Accept: application/json',
            'Content-Type: application/json',
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
