<?php

namespace App\Http\Controllers\Auth;

use \Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
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

        $user = $request->user();
        $user->level = User::LEVEL_5;
        $user->save();

        message()->info("Sua conta foi verificada! Bem vindo!")->flash();

        return redirect()->route("front.index", ["lang" => app()->getLocale()]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendLink(Request $request): RedirectResponse
    {
        if ($request->user()->email_verified_at) {
            message()->info("{$request->user()->first_name}, sua conta já está verifada!")->flash();
            return back();
        }

        $request->user()->sendEmailVerificationNotification();

        message()->info("Link de confirmação reenviado!")->flash();

        return back();
    }
}
