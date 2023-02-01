<?php

namespace App\Services;

use App\Models\Provider;
use App\Repositories\Interfaces\IProviderRepository;

class ProviderService
{
    protected $providerRepository;
    public function __construct(IProviderRepository $providerRepository) {
        $this->providerRepository = $providerRepository;
    }

    public function filter()
    {
        return $this->providerRepository->filter();
    }


    public function delete($provider)
    {

        return $this->providerRepository->delete($provider);
    }


    public function show($id)
    {
        return $this->providerRepository->show($id);
    }


    public function active($id)
    {
        
        return $this->providerRepository->active($id);
    }
}
