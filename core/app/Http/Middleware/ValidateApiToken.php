<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class ValidateApiToken
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
        $apiToken = $request->query('api_token');

        if (!$apiToken) {
            return response()->json(['error' => 'API token is missing'], 401);
        }

        $user = User::where('api_token', $apiToken)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }

        $request->attributes->set('authenticatedUser', $user);

        return $next($request);
    }

}
