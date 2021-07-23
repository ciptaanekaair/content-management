<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SocialiteMidware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $services        = ['google', 'facebook'];
        $enabledServices = [];

        foreach($services as $service) {
            if (config('services'.$service)) {
                $enabledServices[] = $service;
            }
        }

        if (!in_array(strtolower($request->service), $enabledServices)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Invalid social service'
                ], 401);
            }
        } else {
            return redirect()->back();
        }

        return $next($request);
    }
}
