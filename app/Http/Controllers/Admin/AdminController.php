<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRegister;

class AdminController extends Controller
{
    //
    public function home()
    {
        $access = AccessRegister::whereNotNull("id")->orderBy("access", "DESC")->limit(15)->get();

        return view("admin.home", [
            "pageTitle" => "Administração",
            "access" => $access
        ]);
    }
}
