<?php

namespace App\Http\Resources\Api\TicketReservation;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketReservationResource extends JsonResource
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
            'id' => $this->id,
            'price' => $this->price,
            'type' => $this->type,
            'date' => $this->created_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY h:mm a'),
            'departure' => $this->departure,
            'arrival' => $this->arrival,
        ];
    }
}
