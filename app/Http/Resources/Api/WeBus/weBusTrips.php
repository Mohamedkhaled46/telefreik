<?php

namespace App\Http\Resources\Api\WeBus;

use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class weBusTrips extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locationFrom = Location::find($request->from_location_id)->we_id;
        $locationTo = Location::find($request->to_location_id)->we_id;
        $allData = $this[0]??$this;

        $stations_from =collect($allData['stations_from'])->where('city_id',$locationFrom)->map(function ($data, $key) {
            return [
                'id' => $data['id'],
                'name' => $data['name'],
                'time' => request()->travel_date.' '.$data['pivot']['time'].':00',
                'time_id' => $data['pivot']['id'],
                'location_id' => $data['city_id'],
            ];
        })->sortBy('time')->values();
        $stations_to =collect($allData['stations_to'])->where('city_id',$locationTo)->map(function ($data, $key) {
            return [
                'id' => $data['id'],
                'name' => $data['name'],
                'time' => $data['pivot']['time'],
                'time_id' => $data['pivot']['id'],
                'location_id' => $data['city_id'],
            ];
        })->sortBy('time')->values();

        return [
            'trip_id' => $allData['id'],
            'price' => $allData['price'],
            'from_location_id' => $request->from_location_id,
            'to_location_id' => $request->to_location_id,
            'stations_from' => json_encode($stations_from) ,
            'stations_to' =>json_encode($stations_to),
            'seats' => count($allData['seats']),
            'company' => 'WeBus',
            'class' => $allData['category'],
            'type'=> 'WeBus',
            'date'=>$request->travel_date
        ];
    }

}
