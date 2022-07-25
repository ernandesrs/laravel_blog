<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    use HasFactory;

    /**
     * @param string $string
     * @param string $lang validated language code. Ex.: pt_BR, en, en_US
     * @return Slug
     */
    public function set(string $string, string $lang): Slug
    {
        $this->$lang = \Illuminate\Support\Str::slug($string);
        return $this;
    }

    /**
     * @param string $lang validated language code. Ex.: pt_BR, en, en_US
     * @return string|null
     */
    public function slug(string $lang): ?string
    {
        return $this->$lang ?? null;
    }

    /**
     * @return integer|null
     */
    public function hasPages(): ?int
    {
        return Page::where("slug", $this->id)->count();
    }
}
