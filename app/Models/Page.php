<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

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
     * @param string $slug
     * @param string $lang
     * @return Page|null
     */
    public static function findBySlug(string $slug, string $lang): ?Page
    {
        $slug = Slug::where($lang, $slug)->first();
        if (!$slug) return null;

        $page = Page::where("slug", $slug->id)->where("lang", $lang)->first();
        if ($page->content_type == self::CONTENT_TYPE_VIEW)
            $page->content = json_decode($page->content);

        return $page;
    }

    /**
     * @param array $validated
     * @param User|null $user
     * @return Page
     */
    public function set(array $validated, ?User $user = null): Page
    {
        if ($user) $this->author = $user->id;

        $this->title = $validated["title"];
        $this->description = $validated["description"];
        $this->lang = $validated["lang"] ?? config("app.locale");
        $this->content_type = $validated["content_type"] ?? $this->content_type;

        if ($this->content_type == Page::CONTENT_TYPE_VIEW) {
            $content = (array) json_decode($this->content);
            if (!$content)
                $content = ["view_path" => null];

            $content["view_path"] = $validated["view_path"] ?? $content["view_path"];

            $this->content = json_encode($content);
        } else
            $this->content = $validated["content"] ?? $this->content;

        if ($validated["follow"] ?? null)
            $this->follow = true;
        else
            $this->follow = false;

        $this->status = $validated["status"] ?? $this->status;

        if ($this->status == Page::STATUS_SCHEDULED) {
            $this->published_at = null;
            $this->scheduled_to = date("Y-m-d H:i:s");
        } elseif ($this->status == Page::STATUS_PUBLISHED) {
            $this->published_at = date("Y-m-d H:i:s");
            $this->scheduled_to = null;
        } else {
            $this->published_at = null;
            $this->scheduled_to = null;
        }

        return $this;
    }

    /**
     * @return Slug|null
     */
    public function slugs(): ?Slug
    {
        return $this->hasOne(Slug::class, "id", "slug")->get()->first();
    }

    /**
     * @return User|null
     */
    public function author(): ?User
    {
        return $this->hasOne(User::class, "id", "author")->get()->first();
    }
}
