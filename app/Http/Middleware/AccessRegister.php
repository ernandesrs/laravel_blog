<?php

namespace App\Http\Middleware;

use App\Models\AccessRegister as ModelsAccessRegister;
use Closure;
use Illuminate\Http\Request;

class AccessRegister
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
        $accessRegister = ModelsAccessRegister::where("path", $request->path())->first();
        if (!$accessRegister)
            $accessRegister = new ModelsAccessRegister(["path" => $request->path(), "all_access" => 0]);

        $accessRegister->all_access += 1;
        $accessRegister->save();

        return $next($request);
    }
}
