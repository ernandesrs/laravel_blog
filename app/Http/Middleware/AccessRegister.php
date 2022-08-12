<?php

namespace App\Http\Middleware;

use App\Models\AccessRegister as ModelsAccessRegister;
use App\Models\User;
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
        $route = $request->route();
        $routeName = $route->action["as"];
        $routeParams = array_merge($route->parameters, $_GET ?? []);

        $auth = $request->user();
        if (!$auth || !in_array($auth->level, [User::LEVEL_9])) {
            $accessRegister = ModelsAccessRegister::where("path", $request->path())->first();
            if (!$accessRegister)
                $accessRegister = new ModelsAccessRegister([
                    "path" => $request->path(),
                    "access" => 0,
                    "name" => $routeName,
                    "params" => json_encode($routeParams)
                ]);

            $accessRegister->params = json_encode($routeParams);
            $accessRegister->access += 1;
            $accessRegister->save();
        }

        return $next($request);
    }
}
