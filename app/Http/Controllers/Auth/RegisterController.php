<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function register(): \Illuminate\Contracts\View\View
    {
        return view("auth.register", ["pageTitle" => "Registro"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = $this->registerValidator($request);

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
        }

        $validated = (object) $validated;

        $user = new User();
        $user->name = $validated->first_name . " " . $validated->last_name;
        $user->first_name = $validated->first_name;
        $user->last_name = $validated->last_name;
        $user->username = $validated->username;
        $user->email = $validated->email;
        $user->phone = str_replace(["+", "(", ")", " ", "-"], "", $validated->phone);
        $user->password = Hash::make($validated->password);

        if (!$user->save()) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Houve um erro ao criar sua conta")->render()
            ]);
        }

        // SEND VERIFICATION E-MAIL
        event(new Registered($user));

        (new Message())->success("Sua conta foi registrada com sucesso!")->time(10)->flash();
        return response()->json([
            "success" => true,
            "redirect" => route("auth.login")
        ]);
    }

    /**
     * @param Request $request
     * @return
     */
    private function registerValidator(Request $request)
    {
        $only = ["first_name", "last_name", "username", "email", "phone", "password", "password_confirmation"];
        $rules = [
            "first_name" => ["required", "max:50"],
            "last_name" => ["required", "max:50"],
            "username" => ["required", "max:25"],
            "email" => ["required", "unique:App\Models\User", "email", "max:255"],
            "phone" => ["required", "max:20"],
            "password" => ["required", "confirmed"],
            "password_confirmation" => ["required"],
        ];

        if (g_recaptcha()) {
            $only = array_merge($only, ["g-recaptcha-response"]);
            $rules = array_merge($rules, ["g-recaptcha-response" => ["required"]]);
        }

        return Validator::make($request->only($only), $rules);
    }
}
