<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetController extends Controller
{
    /**
     * @param string $token
     * @return View
     */
    public function resetForm(string $token): View
    {
        return view('auth.reset-password', ['token' => $token, "pageTitle" => "Recuperar senha"]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash("flash_message", [
                "type" => "success",
                "message" => __($status)
            ]);
            return redirect()->route("auth.login");
        } else {
            session()->flash("flash_message", [
                "type" => "warning",
                "message" => __($status)
            ]);
            return redirect()->back();
        }
    }
}
