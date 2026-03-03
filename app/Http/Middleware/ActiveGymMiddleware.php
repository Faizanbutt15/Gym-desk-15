<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveGymMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->role === 'gym_admin') {
            $gym = $user->gym;
            if (!$gym || $gym->status !== 'active' || ($gym->subscription_end && $gym->subscription_end < now())) {
                abort(403, 'Your gym subscription is inactive or expired.');
            }
        }
        return $next($request);
    }
}
