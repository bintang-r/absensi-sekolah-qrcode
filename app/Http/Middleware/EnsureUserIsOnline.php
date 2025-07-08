<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1);

            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);

            User::query()
                ->where('id', Auth::user()->id)
                ->update(['last_seen_time' => date('Y-m-d H:i:s')]);
        }

        return $next($request);
    }
}
