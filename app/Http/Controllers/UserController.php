<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index() :UserCollection
    {
        return UserCollection::make(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest  $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request) :UserResource
    {
        $data = $request->input('data.attributes');

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return UserResource
     */
    public function show(User $user) :UserResource
    {
        return UserResource::make($user);
    }
}
