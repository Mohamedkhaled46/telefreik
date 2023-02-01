<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Services\PromotionalOfferService;
use Illuminate\Http\Request;

class PromotionalOfferController extends BaseController
{
    public $promotionalOfferService;

    public function __construct(PromotionalOfferService $promotionalOfferService)
    {
        $this->promotionalOfferService = $promotionalOfferService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = $this->promotionalOfferService->index();
        return $this->sendResponse(array("offers" => (object)$offers), 'Offers Found');
    }
}
