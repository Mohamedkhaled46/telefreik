<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all($request)
    {
        $data['users'] = $this->filter($request);
        $data['roles'] = Role::all();
        $data['states'] = State::all();
        return $data;
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    public function showUser($id)
    {
        return $this->findUser($id);
    }

    public function destroyUser($id)
    {
        return $this->user->destroy($id);
    }

    public function findUser($id)
    {
        return $this->user->find($id);
    }

    public function updateUser($request, $id)
    {
        return $this->findUser($id)->update($request);
    }

    public function filter($request)
    {
        $user = $this->user->query();
        $user->when($request->has('name') && !$request->has('role_id') && !$request->has('state_id'), function ($query) use ($request) {
            return $query->where('name', 'Like', "%" . $request->name . "%");
        });

        $user->when($request->has('role_id') && !$request->has('name') && !$request->has('state_id'), function ($query) use ($request) {
            return $query->where('role_id', $request->role_id);
        });

        $user->when($request->has('state_id') && !$request->has('name') && !$request->has('role_id'), function ($query) use ($request) {
            return $query->where('state_id', $request->state_id);
        });

        $user->when($request->has('role_id') && $request->has('name') && !$request->has('state_id'), function ($query) use ($request) {
            return $query->where('role_id', $request->role_id)
                ->where('name', 'Like', "%" . $request->name . "%");
        });

        $user->when(!$request->has('role_id') && $request->has('name') && $request->has('state_id'), function ($query) use ($request) {
            return $query->where('state_id', $request->state_id)
                ->where('name', 'Like', "%" . $request->name . "%");
        });

        $user->when($request->has('role_id') && !$request->has('name') && $request->has('state_id'), function ($query) use ($request) {
            return $query->where('state_id', $request->state_id)
                ->where('role_id', $request->role_id);
        });

        $user->when($request->has('name') && $request->has('role_id') && $request->has('state_id'), function ($query) use ($request) {
            return $query->where('name', 'Like', "%" . $request->name . "%")
                ->where('role_id', $request->role_id)
                ->where('state_id', $request->state_id);
        });
        return $user->paginate(10);
    }
}
