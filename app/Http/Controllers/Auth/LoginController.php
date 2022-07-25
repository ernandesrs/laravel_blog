<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        $validator = Validator::make($request->only(["email", "password", "g-recaptcha-response"]), [
            "email" => ["required", "email"],
            "password" => ["required"],
            "g-recaptcha-response" => ["required"]
        ], [
            "email.required" => "Informe um email válido",
            "password.required" => "Informe sua senha",
            "g-recaptcha-response.required" => "Desafio obrigatório"
        ]);

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

        // RECAPTCHA
        $response = Http::get("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => env("APP_GOOGLE_RECAPTCHAV2_PRIVATE_KEY"),
            'response' => $validated["g-recaptcha-response"]
        ]);

        unset($validated["g-recaptcha-response"]);

        if ($response->json()["success"] == false) {
            return response()->json([
                "success" => false,
                "errors" => ["g-recaptcha-response" => "Falha no desafio"],
                "message" => message()->warning("Falha ao validar desafio do recaptcha")->time(10)->render()
            ]);
        }

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            $name = auth()->user()->first_name;

            (new Message())->default("Pronto {$name}, agora você está logado! Muito bem vindo!")->time(10)->flash();

            return response()->json([
                "success" => true,
                "redirect" => route("front.home")
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
}
