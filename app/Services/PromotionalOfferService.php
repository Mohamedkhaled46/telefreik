<?php


namespace App\Services;

use App\Repositories\Interfaces\IPromotionalOfferRepository;

class PromotionalOfferService
{
    public $promotionalOfferRepository;
    public function __construct(IPromotionalOfferRepository $promotionalOfferRepository)
    {
        $this->promotionalOfferRepository  = $promotionalOfferRepository;
    }

    public function index()
    {
        return $this->promotionalOfferRepository->index();
    }
}
