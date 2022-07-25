<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class MemberAccess
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
        $user = $request->user();
        if (!$user)
            return redirect()->route("auth.login");

        if ($request->user()->level < User::LEVEL_5)
            return redirect()->route("front.home");

        if (!$request->user()->email_verified_at)
            return redirect()->route("verification.notice");

        return $next($request);
    }
}
