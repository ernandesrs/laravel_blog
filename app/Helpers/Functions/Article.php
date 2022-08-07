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
        "medium" => [800, 600],
        "large" => [1200, 800],
    ];

    $dimensions = is_array($size) ? $size : $predefinedDimensions[$size] ?? $predefinedDimensions["normal"];

    $width = $dimensions[0];
    $height = $dimensions[1];

    if ($article->cover && file_exists(Storage::path("public/{$article->cover}")))
        return thumb(Storage::path("public/{$article->cover}"), $width, $height);

    return thumb(resource_path("img/default-image.png"), $width, $height);
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
