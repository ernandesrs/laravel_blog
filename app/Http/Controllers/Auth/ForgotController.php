<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotController extends Controller
{
    /**
     * @return View
     */
    public function forgotForm(): View
    {
        return view('auth.forgot-password', ["pageTitle" => "Esquecia a senha"]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT)
            session()->flash("flash_message", [
                "type" => "info",
                "message" => __($status)
            ]);
        else
            session()->flash("flash_message", [
                "type" => "warning",
                "message" => __($status)
            ]);

        return redirect()->back();
    }
}
