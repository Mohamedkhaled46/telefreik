<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function index()
    {
        if (request('search')) {
            $users = User::where('name', 'like', '%' . request('search') . '%')->get();
        } else {
            $users = User::all();
        }
        return view('dashboard', compact('users'));
    }
}
