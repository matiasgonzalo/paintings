<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class VerifyHeaderKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->headers->has('x-http-user-id')) {
            $user_id = $request->header('x-http-user-id');
            $user = User::whereId($user_id)->first();
            if ($user) {
                return $next($request);
            }
        }
        abort(403, 'Unauthorized action.');
    }
}
