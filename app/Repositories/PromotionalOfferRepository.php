<?php


namespace App\Repositories;

use App\Http\Resources\Api\PromotionalOffer\PromotionalOfferResource;
use App\Models\PromotionalOffer;
use App\Repositories\Interfaces\IPromotionalOfferRepository;

class PromotionalOfferRepository implements IPromotionalOfferRepository
{
    // display latest 10 records
    public function index()
    {
        $offers = PromotionalOffer::where('active', true)->latest()->take(5)->get();
        return PromotionalOfferResource::collection($offers);
    }
}
