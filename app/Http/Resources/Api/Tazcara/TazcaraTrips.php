<?php

namespace App\Http\Resources\Api\Tazcara;

use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class TazcaraTrips extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $routes =collect($this['details']['route'])->map(function ($data, $key) {
            return [
                'id' => $data['boarding_point']['id'],
                'name' => $data['boarding_point']['name'],
                'time' => $data['date']['timestamp'],
                'time_id' => $data['date']['id'],
                'location_id' => $data['city']['id'],

            ];
        })->sortBy('time')->values();

        $locationFrom = Location::find($request->from_location_id)->tazcara_id;
        $locationTo = Location::find($request->to_location_id)->tazcara_id;
        return [
            'trip_id' => $this['details']['trip']['id'],
            'price' => $this['price'],
            'from_location_id' => $request->from_location_id,
            'to_location_id' => $request->to_location_id,
            'stations_from' => json_encode($routes->where('location_id', $locationFrom)->values()->all()),
            'stations_to' => json_encode($routes->where('location_id', $locationTo)->values()->all()),
            'company' => $this['company']['official_name'],
            'seats' => $this['details']['bus']['seats'],
            'class' => $this['details']['class']['name'],
            'type' => "tazcara",
            'date' => $request->travel_date,
        ];
    }

}
