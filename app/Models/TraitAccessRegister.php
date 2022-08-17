<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Route;

trait TraitAccessRegister
{
    /**
     * @return HasOne
     */
    public function access(): HasOne
    {
        return $this->hasOne(AccessRegister::class, "id", "access_register_id");
    }

    /**
     * @return void
     */
    public function register(): void
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

            $accessRegister = $this->access()->first();
        }

        $accessRegister->register();

        return;
    }
}
