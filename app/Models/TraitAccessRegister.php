<?php

namespace App\Models;

use Illuminate\Support\Facades\Route;

trait TraitAccessRegister
{
    public function access()
    {
        return $this->hasOne(AccessRegister::class, "id", "access_register_id");
    }

    public function register()
    {
        $accessRegister = $this->access()->first();

        if (!$accessRegister) {
            $accessRegister = new AccessRegister([
                "name" => Route::currentRouteName(),
                "params" => json_encode(Route::current()->parameters),
                "access" => 0,
            ]);

            $accessRegister->save();

            $this->access_register_id = $accessRegister->id;

            $this->save();
        }

        return $accessRegister->register();
    }
}
