<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerOTP;
use App\Models\Location;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\ILocationRepository;
use Illuminate\Support\Facades\DB;

class LocationRepository implements ILocationRepository
{
    public $location;
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function get()
    {

        return $this->location->paginate(50);
    }

}
