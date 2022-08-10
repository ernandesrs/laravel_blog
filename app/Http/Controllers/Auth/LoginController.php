<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function login(): \Illuminate\Contracts\View\View
    {
        return view("auth.login", ["pageTitle" => "Login"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = $this->loginValidator($request);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Erro ao validar os dados informados")->render(),
                "errors" => array_map(function ($item) {
                    return $item[0];
                }, $errors)
            ]);
        }

        $validated = $validator->validated();

        if (g_recaptcha()) {
            if (g_recaptcha_verify($validated) == false) {
                return response()->json([
                    "success" => false,
                    "errors" => ["g-recaptcha-response" => "Falha no desafio"],
                    "message" => message()->warning("Falha ao validar desafio do recaptcha")->time(10)->render()
                ]);
            }

            unset($validated["g-recaptcha-response"]);
        }

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            $user = auth()->user();

            (new Message())->default("Pronto {$user->first_name}, agora você está logado! Muito bem vindo!")->time(10)->flash();

            if ($user->level == User::LEVEL_9)
                $route = "admin.home";
            else
                $route = "front.home";

            return response()->json([
                "success" => true,
                "redirect" => route($route)
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => (new Message())->warning(__("auth.failed"))->render()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route("front.home");
    }

    /**
     * @param Request $request
     * @return
     */
    private function loginValidator(Request $request)
    {
        $only = ["email", "password"];
        $rules = [
            "email" => ["required", "email"],
            "password" => ["required"]
        ];

        if (g_recaptcha()) {
            $only = array_merge($only, ["g-recaptcha-response"]);
            $rules = array_merge($rules, ["g-recaptcha-response" => ["required"]]);
        }

        return Validator::make($request->only($only), $rules, [
            "email.required" => "Informe um email válido",
            "password.required" => "Informe sua senha",
            "g-recaptcha-response.required" => "Desafio obrigatório"
        ]);
    }
}
