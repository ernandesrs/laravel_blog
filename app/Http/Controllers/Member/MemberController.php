<?php

namespace App\Http\Controllers\Member;

use App\Helpers\Message\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Rolandstarke\Thumbnail\Facades\Thumbnail;

class MemberController extends Controller
{
    //
    public function home()
    {
        return view("member.home", [
            "pageTitle" => "Dashboard"
        ]);
    }

    public function example()
    {
        return view("member.home", ["pageTitle" => "Example"]);
    }

    public function exampleTwo()
    {
        return view("member.home", ["pageTitle" => "Example Two"]);
    }

    /**
     * @return View
     */
    public function profile(): View
    {
        return view("member.profile", [
            "pageTitle" => "Meu perfil",
            "profile" => auth()->user()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profileUpdate(Request $request): JsonResponse
    {
        $data = $request->only(["first_name", "last_name", "photo", "password", "password_confirmation"]);
        $rules = [
            "first_name" => ["required"],
            "last_name" => ["required"],
            "photo" => ["mimes:jpg,png", "max:2048"]
        ];

        if (!empty($data["password"])) {
            $rules += [
                "password" => ["required", "min:6", "max:18", "confirmed"]
            ];
        }

        $validator = Validator::make($data, $rules);

        if ($errors = $validator->errors()->messages()) {
            return response()->json([
                "success" => false,
                "message" => (new Message())->warning("Erro ao validar os dados informados")->render(),
                "errors" => array_map(function ($item) {
                    return $item[0];
                }, $errors)
            ]);
        }

        /** @var User */
        $user = auth()->user();
        $validated = $validator->validated();

        // PHOTO UPLOAD
        if ($validated["photo"] ?? null) {
            $photo = $validated["photo"];
            $path = $photo->store("public/avatars");

            if ($user->photo) {
                Thumbnail::src(Storage::path($user->photo))->delete();
                Storage::delete($user->photo);
            }

            $user->photo = $path;
        }

        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];

        if (!empty($validated["password"]))
            $user->password = Hash::make($validated["password"]);

        $user->save();

        (new Message())->success("{$user->first_name}, seus dados foram atualizados com sucesso!")->float()->flash();
        return response()->json([
            "success" => true,
            "reload" => true,
        ]);
    }
}
