<?php

use App\Helpers\Message\Message;
use Rolandstarke\Thumbnail\Facades\Thumbnail;

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
    return Thumbnail::src($path)->crop($width, $height ?? $width)->url();
}

/**
 * @return Message
 */
function message(): Message
{
    return (new Message());
}
