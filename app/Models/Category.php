<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * @return HasOne
     */
    public function slugs(): HasOne
    {
        return $this->hasOne(Slug::class, "id", "slug_id");
    }
}
