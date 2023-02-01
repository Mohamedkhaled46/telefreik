<?php

namespace App\Http\Resources\Api\PromotionalOffer;

use App\Services\UploadService;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionalOfferResource extends JsonResource
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
            'title' => $this->title,
            'brief' => $this->brief,
            'image' => UploadService::getFile($this->image),
        ];
    }
}
