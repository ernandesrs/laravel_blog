<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * @return Slug|null
     */
    public function slugs(): ?Slug
    {
        return $this->hasOne(Slug::class, "id", "slug_id")->first();
    }
}
