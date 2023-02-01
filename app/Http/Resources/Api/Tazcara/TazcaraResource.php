<?php

namespace App\Http\Resources\Api\Tazcara;

use Illuminate\Http\Resources\Json\JsonResource;

class TazcaraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [
            'tazcara_id' => $this['id'],
            'name_en' => $this['city_name'],
            'name_ar' => $this['city_name']
        ];
    }

}
