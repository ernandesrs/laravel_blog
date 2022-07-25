<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;

/**
 * @param User $user
 * @param string|array $size pode ser 'small', 'normal', 'medium', 'large', ou array com as dimensões desejadas, exemplo: [100, 100]
 * @return string
 */
function m_user_photo_thumb(User $user, $size = "normal"): string
{
    $predefinedDimensions = [
        "small" => [75, 75],
        "normal" => [250, 250],
        "medium" => [500, 500],
        "large" => [720, 720],
    ];

    $dimensions = is_array($size) ? $size : $predefinedDimensions[$size] ?? $predefinedDimensions["normal"];

    $width = $dimensions[0];
    $height = $dimensions[1];

    if ($user->photo && file_exists(Storage::path($user->photo)))
        return thumb(Storage::path($user->photo), $width, $height);

    $hash = md5(strtolower(trim($user->email)));

    return "https://www.gravatar.com/avatar/{$hash}?s={$width}&d=robohash";
}

/**
 * Obtém array de gêneros do modelo User
 * @return array
 */
function m_user_genders(): array
{
    return User::GENDERS;
}

/**
 * Obtém array de níveis de usuário do modelo User
 * @return array
 */
function m_user_levels(): array
{
    return User::LEVELS;
}
