<?php

/**
 * 
 * 
 * Funções para auxiliar e facilitar na composição do template
 * 
 * 
 */

/**
 * @param string $text
 * @param string $style
 * @param string $activeIcon
 * @param string|null $link
 * @param string|null $altIcon
 * @param string|null $id
 * @return array
 */
function t_button_data(string $text, string $style, string $activeIcon, ?string $link = null, ?string $altIcon = null, ?string $id = null): array
{
    return t_clickable_data("button", $text, $style, $activeIcon, $link, $altIcon, $id);
}

/**
 * @param string $text
 * @param string $style
 * @param string $activeIcon
 * @param string|null $link
 * @param string|null $altIcon
 * @param string|null $id
 * @return array
 */
function t_button_link_data(string $text, string $style, string $activeIcon, ?string $link = null, ?string $altIcon = null, ?string $id = null): array
{
    return t_clickable_data("link", $text, $style, $activeIcon, $link, $altIcon, $id);
}

/**
 * @param string $type
 * @param string $text
 * @param string $style
 * @param string $activeIcon
 * @param string|null $link
 * @param string|null $altIcon
 * @param string|null $id
 * @return array
 */
function t_clickable_data(string $type = "button", string $text, string $style, string $activeIcon, ?string $link = null, ?string $altIcon = null, ?string $id = null): array
{
    return [
        "id" => $id,
        "type" => $type,
        "text" => $text,
        "style" => $style,
        "link" => $link,
        "activeIcon" => $activeIcon,
        "altIcon" => $altIcon
    ];
}

/**
 * @param string $style
 * @param string $message
 * @param string|null $text
 * @param string|null $icon
 * @param string|null $link
 * @return array|null
 */
function t_button_confirmation_data(string $style, string $message, ?string $text = null, ?string $icon = null, ?string $link = null): ?array
{
    return t_clickable_confirmation_data("button", $style, $message, $text, $icon, $link);
}

/**
 * @param string $style
 * @param string $message
 * @param string|null $text
 * @param string|null $icon
 * @param string|null $link
 * @return array|null
 */
function t_button_link_confirmation_data(string $style, string $message, ?string $text = null, ?string $icon = null, ?string $link = null): ?array
{
    return t_clickable_confirmation_data("link", $style, $message, $text, $icon, $link);
}

/**
 * @param string $type
 * @param string $style
 * @param string $message
 * @param string $text
 * @param string $icon
 * @param string|null $link
 * @return array|null
 */
function t_clickable_confirmation_data(string $type = "button", string $style, string $message, ?string $text = null, ?string $icon = null, ?string $link = null): ?array
{
    return [
        'btnClass' => ($type == "link" ? "btn-link text-" : ($type == "button" ? "btn-" : "btn-outline-")) . $style,
        'btnIcon' => $icon,
        'btnType' => $style,
        'btnMessage' => $message,
        'btnAction' => $link,
        'btnText' => $text,
    ];
}
