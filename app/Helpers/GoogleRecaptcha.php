<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GoogleRecaptcha
{
    private const GOOGLE_RECAPTCHA_URL_VERIFY = "https://www.google.com/recaptcha/api/siteverify";



    /**
     * @return void
     */
    public static function gRecaptchaRender(): void
    {
        echo "<div class='g-recaptcha' data-sitekey='" . env('APP_GOOGLE_RECAPTCHAV2_SITE_KEY') . "'></div>";
        return;
    }

    /**
     * @param array|string $param
     * @return boolean
     */
    public static function gRecaptchaVerify($param): bool
    {
        $token = is_array($param) ? $param["g-recaptcha-response"] ?? null : $param;

        if (!$token) return false;

        $response = Http::get(self::GOOGLE_RECAPTCHA_URL_VERIFY, [
            'secret' => env("APP_GOOGLE_RECAPTCHAV2_PRIVATE_KEY"),
            'response' => $token
        ]);

        return ($response ?? false) ? $response["success"] : false;
    }
}
