<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRegister;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function home()
    {
        return view("admin.home", [
            "pageTitle" => "Administração",
            "access" => AccessRegister::whereNotNull("id")->orderBy("access", "DESC")->limit(5)->get()
        ]);
    }
}
