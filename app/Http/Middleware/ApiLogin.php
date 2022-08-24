<?php

namespace App\Http\Middleware;

use App\Http\Requests\LoginRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $loginRequestInstance = new LoginRequest();
        Validator::make($request->all(), $loginRequestInstance->rules())->validate();

        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'state' => false,
                'message' => 'Login information is invalid.'
            ], 401);

        }

        return $next($request);
    }
}
