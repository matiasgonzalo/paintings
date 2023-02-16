<?php

namespace App\Http\Middleware;

use Closure;

class ValidateJsonApiDocument
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
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $request->validate([
                'data'      => ['required', 'array'],
                'data.type' => ['required', 'string'],
                'data.attributes' => ['required', 'array'],
            ]);
        }

        return $next($request);
    }
}
