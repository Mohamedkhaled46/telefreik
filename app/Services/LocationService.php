<?php
namespace App\Services;

use App\Models\Ticket;
use App\Repositories\Interfaces\ILocationRepository;


class LocationService
{
    protected $locationRepository;
    public function __construct(ILocationRepository $locationRepository) {
        $this->locationRepository = $locationRepository;
    }

    public function get()
    {
//        dd("hello");
        return $this->locationRepository->get();
    }


}
