<?php

namespace App\Http\Controllers\Auth;

use \Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * @return View
     */
    public function notice(): View
    {
        return view('auth.verify-email', ["pageTitle" => "Verifique seu email"]);
    }

    /**
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();
        session()->flash("flash_message", [
            "type" => "info",
            "message" => "Sua conta foi verificada! Bem vindo!"
        ]);
        return redirect()->route("front.home");
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendLink(Request $request): RedirectResponse
    {
        $request->user()->sendEmailVerificationNotification();
        session()->flash("flash_message", [
            "type" => "info",
            "message" => "Link de confirmação reenviado!"
        ]);
        return back();
    }
}
