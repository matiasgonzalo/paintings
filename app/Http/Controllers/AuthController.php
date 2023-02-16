<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\AuthLoginRequest;

class AuthController extends Controller
{
    /**
     * Login
     *
    * @return AnonymousResourceCollection
     *
     * @bodyParam  email string required user's email. Example: test@mail.com
     * @bodyParam  password string required user's password. Example: 123456
     *
    */
    public function login (AuthLoginRequest $request)
    {
        try {
            $response = AuthService::getToken($request);
            return response()->json(['data' => $response], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
