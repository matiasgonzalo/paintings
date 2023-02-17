<?php
namespace App\Services;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\PasswordIncorrectoException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UsuarioDeshabilitadoException;
use App\Role;
use Illuminate\Support\Facades\Log;

class AuthService {
    /**
     * gets the user and return a new token
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public static function getToken($request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (isset($user)) {
                if (Hash::check($request['password'], $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    return [
                        'id' => $user->id,
                        'access_token' => $token,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->getRoleNames(),
                        'token_type'=>'Bearer'
                    ];
                } else {
                    throw new \Exception('Usuario y/o contraseña incorrectos.', 404);
                }
            }
            throw new \Exception('Usuario y/o contraseña incorrectos.', 404);
        } catch (\Exception $e) {
            throw($e);
        }
    }
}
