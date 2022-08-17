<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Registra acesso
     * 
     * @param \App\Models\Page|\App\Models\Article $monitorable
     * @return void
     */
    protected function registerAccess($monitorable)
    {
        // IMPEDE REGISTRO DE ACESSO DE ADMINISTRADOR
        if (auth()->user() && in_array(auth()->user()->level, [\App\Models\User::LEVEL_9]))
            return;

        $monitorable->register();

        return;
    }
}
