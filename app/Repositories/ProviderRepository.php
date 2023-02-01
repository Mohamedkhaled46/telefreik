<?php

namespace App\Repositories;

use App\User;
use App\Models\Provider;
use App\Repositories\Interfaces\IProviderRepository;

class ProviderRepository implements IProviderRepository
{
    public $provider;
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function delete($provider)
    {
        $isDeleted = $provider->delete();
        return !!$isDeleted;
    }

    public function show($id)
    {
        return $this->provider->where('id', $id)->withTrashed()->first();
    }

    public function filter()
    {
        $provider = $this->provider->query();
        $provider->when(request()->has('name') && !request()->has('type'), function ($query) {
            return $query->where('name', 'Like', "%" . request('name') . "%");
        });
        $provider->when(request()->has('type') && !request()->has('name'), function ($query) {
            return $query->where('type', request('type'));
        });

        $provider->when(request()->has('name') && request()->has('type'), function ($query) {
            return $query->where('name', 'Like', "%" . request('name') . "%")
                ->orWhere('type', request('type'));
        });
        return $provider->withTrashed()->paginate(10);
    }

    public function active($id)
    {
        $provider = $this->provider->withTrashed()->findOrFail($id);
        $isActive = $provider->update([
            'deleted_at' => null
        ]);
        return ((bool)$isActive) ? $provider->refresh() : false;
    }
}
