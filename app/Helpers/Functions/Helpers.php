<?php

use App\Helpers\GoogleRecaptcha;
use App\Helpers\Message\Message;
use App\Helpers\Thumb;
use Illuminate\Support\Facades\Storage;

/**
 * Obtém valor de $data
 * @param [type] $data
 * @param [type] $key
 * @return null|string
 */
function input_value($data, $key)
{
    if (!$data) return null;

    $data = is_array($data) ? (object) $data : $data;

    return $data->$key ?? null;
}

/**
 * @param string $name
 * @return string
 */
function icon_class(string $name): string
{
    return "icon " . config("app-icons." . $name);
}

/**
 * @param string $name
 * @param string|null $alt
 * @return string
 */
function icon_elem(string $name, ?string $alt = null): string
{
    $activeIcon = icon_class($name);
    $altIcon = $alt ? "data-active-icon='{$activeIcon}' data-alt-icon='" . icon_class($alt) . "'" : null;
    echo "<span class='{$activeIcon}' {$altIcon}></span>";
    return "";
}

/**
 * @param string|null $path
 * @param integer $width
 * @param integer|null $height
 * @return null|string
 */
function thumb(?string $path, int $width, ?int $height = null): ?string
{
    if (!$path) return null;
    return Storage::url(Thumb::make($path, $width, $height));
}

/**
 * @return Message
 */
function message(): Message
{
    return (new Message());
}

/**
 * @param [type] $str
 * @param integer $decimals
 * @return string
 */
function money_formatter($str, int $decimals = 2): string
{
    return number_format($str, $decimals, ",", ".");
}

/**
 * @return boolean
 */
function g_recaptcha(): bool
{
    return env("APP_USE_RECAPTCHA", false);
}

/**
 * Renderiza o desafio
 * @return void
 */
function g_recaptcha_render(): void
{
    GoogleRecaptcha::gRecaptchaRender();
    return;
}

/**
 * @param string|array $param string com o token ou array com os dados do formulário com o token
 * @return boolean
 */
function g_recaptcha_verify($param): bool
{
    return GoogleRecaptcha::gRecaptchaVerify($param);
}
