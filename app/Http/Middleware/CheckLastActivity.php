<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLastActivity
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
        if (auth()->check() && auth()->user()->last_activity) {
            $lastActivity = auth()->user()->last_activity;
            $inactiveTime = now()->diffInDays($lastActivity);
            if ($inactiveTime > 30) {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'You have been logged out due to inactivity.'], 401);
            }
            if($lastActivity < now()->format('Y-m-d')) {
                auth()->user()->update(['last_activity' => now()->format('Y-m-d')]);
            }
        }

        return $next($request);
    }
}
