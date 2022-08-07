<?php

/**
 * 
 * 
 * Funções para auxiliar e facilitar na composição do template
 * 
 * 
 */

function t_button_data(string $class, ?string $text =null, ?string $link = null, string $activeIcon, ?string $altIcon = null, ?string $id = null): stdClass
{
    return t_clickable_data("button", $class, $text, $link, $activeIcon, $altIcon, $id);
}

function t_button_link_data(string $class, ?string $text = null, ?string $link = null, string $activeIcon = null, ?string $altIcon = null, ?string $id = null): stdClass
{
    return t_clickable_data("link", $class, $text, $link, $activeIcon, $altIcon, $id);
}

function t_button_confirmation_data(string $type, string $class, string $message, ?string $link = null, ?string $text = null, ?string $icon = null): ?stdClass
{
    return t_clickable_confirmation_data("button", $type, $class, $message, $link, $text, $icon);
}

function t_button_link_confirmation_data(string $type, string $class, string $message, ?string $link = null, ?string $text = null, ?string $icon = null): ?stdClass
{
    return t_clickable_confirmation_data("link", $type, $class, $message, $link, $text, $icon);
}

function t_clickable_data(string $type = "button", string $class, ?string $text = null, ?string $link = null, ?string $activeIcon = null, ?string $altIcon = null, ?string $id = null): stdClass
{
    return (object) [
        "btnType" => $type,
        "btnClass" => $class,
        "btnActiveIcon" => $activeIcon,
        "btnAltIcon" => $altIcon,
        "btnId" => $id,
        "btnLink" => $link,
        "btnText" => $text
    ];
}

function t_clickable_confirmation_data(string $type, string $style, string $class, string $message, ?string $link = null, ?string $text = null, ?string $icon = null): ?stdClass
{
    return (object) [
        'btnClass' => $class,
        'btnIcon' => $icon,
        'btnType' => $type,
        'btnStyle' => $style,
        'btnMessage' => $message,
        'btnAction' => $link,
        'btnText' => $text,
    ];
}
