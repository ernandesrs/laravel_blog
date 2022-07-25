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
        if (g_recaptcha()) {
            $gRecaptchaToken = $request->get('g-recaptcha-response', null);
            if (!$gRecaptchaToken) {
                message()->warning("Desafio recaptcha obrigatório")->flash();
                return redirect()->back();
            }

            if (g_recaptcha_verify($gRecaptchaToken) == false) {
                message()->warning("Complete desafio recaptcha")->flash();
                return redirect()->back();
            }
        }

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT)
            message()->info(__($status))->flash();
        else
            message()->warning(__($status))->flash();

        return redirect()->back();
    }
}
