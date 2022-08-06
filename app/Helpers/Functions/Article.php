<?php

use App\Models\Article;
use Illuminate\Support\Facades\Storage;

/**
 * @param Article $article
 * @param string|array $size pode ser 'small', 'normal', 'medium', 'large', ou array com as dimensões desejadas, exemplo: [1200, 800]
 * @return string
 */
function m_article_cover_thumb(Article $article, $size = "normal"): string
{
    $predefinedDimensions = [
        "small" => [125, 75],
        "normal" => [375, 200],
        "medium" => [600, 400],
        "large" => [1200, 800],
    ];

    $dimensions = is_array($size) ? $size : $predefinedDimensions[$size] ?? $predefinedDimensions["normal"];

    $width = $dimensions[0];
    $height = $dimensions[1];

    if ($article->cover && file_exists(Storage::path($article->cover)))
        return thumb(Storage::path($article->cover), $width, $height);

    $hash = md5(strtolower(trim($article->email)));

    return "https://www.gravatar.com/avatar/{$hash}?s={$width}&d=robohash";
}

/**
 * Obtém array de tipos de conteúdo do modelo Article
 * @return array
 */
function m_article_content_types(): array
{
    return Article::CONTENT_TYPES;
}

/**
 * Obtém array de status de página do modelo Article
 * @return array
 */
function m_article_status(): array
{
    return Article::STATUS;
}

/**
 * Obtém array de tipos de proteção
 * @return array
 */
function m_article_protections(): array
{
    return Article::PROTECTIONS;
}
