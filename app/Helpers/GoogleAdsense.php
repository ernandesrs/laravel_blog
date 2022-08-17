<?php

namespace App\Helpers;

class GoogleAdsense
{
    private const showWhenIn = "production";

    /**
     * @return boolean
     */
    public static function gads(): bool
    {
        return env("APP_GOOGLE_ADSENSE", false);
    }

    /**
     * @return string
     */
    public static function script(): string
    {
        if (self::gads() && env("APP_ENV") == self::showWhenIn)
            return env("APP_GOOGLE_ADSENSE_SCRIPT");
        return "";
    }

    /**
     * @return string
     */
    public static function blockads(): string
    {
        if (self::gads() && env("APP_ENV") == self::showWhenIn)
            return env("APP_GOOGLE_ADSENSE_BLOCKADS");
        return "<img class='img-fluid' src='" . asset("assets/img/example/ads250x250.jpg") . "' alt='ads250x250'>";
    }

    /**
     * @return string
     */
    public static function horizontalads(): string
    {
        if (self::gads() && env("APP_ENV") == self::showWhenIn)
            return env("APP_GOOGLE_ADSENSE_HORIZONTALADS");
        return "<img class='img-fluid' src='" . asset("assets/img/example/ads728x90.jpg") . "' alt='ads728x90'>";
    }

    /**
     * @return string
     */
    public static function inarticleads(): string
    {
        if (self::gads() && env("APP_ENV") == self::showWhenIn)
            return env("APP_GOOGLE_ADSENSE_INARTICLEADS");
        return "<img class='img-fluid' src='" . asset("assets/img/example/ads728x90.jpg") . "' alt='ads728x90'>";
    }
}
