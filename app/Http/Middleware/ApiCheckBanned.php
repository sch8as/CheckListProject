<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiCheckBanned
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
        if(auth()->check() && (auth()->user()->status == User::STATUS_BANNED)){
            //$request->session()->invalidate();
            //$request->session()->regenerateToken();
            return response()->json([
                'state' => false,
                'error' => 'Your Account is suspended, please contact Admin.',
            ], 401);
        }

        return $next($request);
    }
}
