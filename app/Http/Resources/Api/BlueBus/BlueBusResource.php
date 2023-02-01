<?php

namespace App\Http\Resources\Api\BlueBus;

use Illuminate\Http\Resources\Json\JsonResource;

class BlueBusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd($tis);
        $data =  [
            'blue_bus_id' => $this['id'],
            'name_en' => $this['name_en'],
            'name_ar' => $this['name_ar'],
            'blue_bus_parent_id' => (isset($this['city_id']) && $this['city_id']) ? $this['city_id'] :null,
        ];

        return $data ;
    }

}
