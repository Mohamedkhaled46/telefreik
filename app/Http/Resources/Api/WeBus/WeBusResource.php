<?php

namespace App\Http\Resources\Api\WeBus;

use Illuminate\Http\Resources\Json\JsonResource;

class WeBusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $allData = [];

        if(isset($this['translations'][0])){
            foreach ($this['translations'] as $translation){
                $allData['name_'.$translation['locale']] = $translation['name'];
            }
        }
        if(!isset($this['translations'][0]) || empty($allData)){
            $allData['name_en'] = $this['name'];
            $allData['name_ar'] = $this['name'];
        }
        return [
            'we_id' => $this['id'],
            'name_en' => $allData['name_en'],
            'name_ar' => $allData['name_ar'],
        ];
    }

}
