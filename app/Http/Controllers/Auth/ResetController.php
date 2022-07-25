<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->only("email", "password", "password_confirmation", "token"), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            message()->warning("Erro! Informe todos dados e tente de novo.")->flash();
            return back();
        }

        $status = Password::reset(
            $validator->validated(),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            message()->success(__($status))->flash();
            return redirect()->route("auth.login");
        } else {
            message()->warning(__($status))->flash();
            return redirect()->back();
        }
    }
}
