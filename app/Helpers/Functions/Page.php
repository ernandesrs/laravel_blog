<?php

use App\Models\Page;
use Illuminate\Support\Facades\Storage;

/**
 * @param Page $page
 * @param string|array $size pode ser 'small', 'normal', 'medium', 'large', ou array com as dimensões desejadas, exemplo: [1200, 800]
 * @return string
 */
function m_page_cover_thumb(Page $page, $size = "normal"): string
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

    if ($page->cover && file_exists(Storage::path("public/{$page->cover}")))
        return thumb(Storage::path("public/{$page->cover}"), $width, $height);

    return thumb(resource_path("img/default-image.png"), $width, $height);
}

/**
 * Obtém array de tipos de conteúdo do modelo Page
 * @return array
 */
function m_page_content_types(): array
{
    return Page::CONTENT_TYPES;
}

/**
 * @return string
 */
function m_page_content_text(): string
{
    return Page::CONTENT_TYPE_TEXT;
}

/**
 * @return string
 */
function m_page_content_view(): string
{
    return Page::CONTENT_TYPE_VIEW;
}

/**
 * Obtém array de status de página do modelo Page
 * @return array
 */
function m_page_status(): array
{
    return Page::STATUS;
}

/**
 * @return string
 */
function m_page_status_draft(): string
{
    return Page::STATUS_DRAFT;
}

/**
 * @return string
 */
function m_page_status_scheduled(): string
{
    return Page::STATUS_SCHEDULED;
}

/**
 * @return string
 */
function m_page_status_published(): string
{
    return Page::STATUS_PUBLISHED;
}

/**
 * Obtém array de tipos de proteção
 * @return array
 */
function m_page_protections(): array
{
    return Page::PROTECTIONS;
}

/**
 * @return string
 */
function m_page_protection_none(): string
{
    return Page::PROTECTION_NONE;
}

/**
 * @return string
 */
function m_page_protection_author(): string
{
    return Page::PROTECTION_AUTHOR;
}

/**
 * @return string
 */
function m_page_protection_system(): string
{
    return Page::PROTECTION_SYSTEM;
}
