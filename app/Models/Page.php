<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    use HasFactory;
    use TraitAccessRegister;

    public const CONTENT_TYPE_TEXT = "text";
    public const CONTENT_TYPE_VIEW = "view";

    public const STATUS_DRAFT = "draft";
    public const STATUS_SCHEDULED = "scheduled";
    public const STATUS_PUBLISHED = "published";

    public const PROTECTION_NONE = 1;
    public const PROTECTION_AUTHOR = 2;
    public const PROTECTION_SYSTEM = 9;

    /**
     * Allowed content types
     * @param array<string>
     */
    public const CONTENT_TYPES = [self::CONTENT_TYPE_TEXT, self::CONTENT_TYPE_VIEW];

    /**
     * Allowed status
     * @param array<string>
     */
    public const STATUS = [self::STATUS_DRAFT, self::STATUS_SCHEDULED, self::STATUS_PUBLISHED];

    public const PROTECTIONS = [self::PROTECTION_NONE, self::PROTECTION_AUTHOR, self::PROTECTION_SYSTEM];

    /**
     * @param array $validatedData
     * @return string
     */
    public function getContent(array $validatedData): string
    {
        if ($validatedData["content_type"] == self::CONTENT_TYPE_VIEW) {
            $content = [
                "view_path" => $validatedData["view_path"]
            ];
            return json_encode($content);
        }

        return $validatedData["content"];
    }

    /**
     * @param string $slug
     * @param string $lang
     * @return Page|null
     */
    public static function findBySlug(string $slug, string $lang): ?Page
    {
        $slug = Slug::where($lang, $slug)->first();
        if (!$slug) return null;

        $page = Page::where("slug_id", $slug->id)->where("lang", $lang)->first();
        if ($page->content_type == self::CONTENT_TYPE_VIEW)
            $page->content = json_decode($page->content);

        return $page;
    }

    /**
     * @return HasOne
     */
    public function slugs(): HasOne
    {
        return $this->hasOne(Slug::class, "id", "slug_id");
    }

    /**
     * @return User|null
     */
    public function author(): ?User
    {
        return $this->hasOne(User::class, "id", "user_id")->get()->first();
    }
}
