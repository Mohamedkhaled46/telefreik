<?php

namespace App\Http\Resources\Api\BlueBus;

use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class BlueBusTripsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $locationFrom = Location::find($request->from_location_id);
        $locationTo = Location::find($request->to_location_id);
        $locationFromId = $locationFrom->blue_bus_parent_id ?? $locationFrom->blue_bus_id;
        $locationToId = $locationTo->blue_bus_parent_id ?? $locationTo->blue_bus_id;

        $routes =collect($this['route_lines'])
            ->where("from_city_id",$locationFromId)
            ->where("to_city_id",$locationToId)
            ->first();
        $stationFrom =
        [
            [
            'id' =>$locationFrom->blue_bus_id,
            'name' =>$locationFrom->name_ar,
            'time' => $this['date'].' '.$this['time'] ,
            'time_id' => null,
            'location_id' => $locationFrom->id
            ]
        ];
        $stationTo =
        [
            [

                'id' =>$locationTo->blue_bus_id,
                'name' =>$locationTo->name_ar,
                'time' => null ,
                'time_id' => null,
                'location_id' => $locationTo->id,
            ]
        ];


         return $data =  [
            'trip_id' => $this['id'],
            'price' => $routes['prices'][0]['price'],
            'from_location_id' => request()->from_location_id,
            'to_location_id' => request()->to_location_id,
            'stations_from' => json_encode($stationFrom),
            'stations_to' => json_encode($stationTo),
            'company' => "Blue Bus",
            'seats' =>$this['bus_salon'] ? count($this['bus_salon']['layout']):null,
            'class' => $routes['prices'][0]['seat_type']['name_en'] ?? $this['bus_salon']['name'],
            'type' => "Blue Bus",
            'date' => $request->travel_date,
        ];
    }

}
