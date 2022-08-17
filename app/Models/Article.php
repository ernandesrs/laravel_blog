<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Article extends Page
{
    use HasFactory;
    use TraitAccessRegister;

    /**
     * Retorna categorias
     * 
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Retorna Collection com os ids das categories
     *
     * @return Collection
     */
    public function categoriesId(): Collection
    {
        $categories = $this->categories()->get();
        
        return $categories->map(function ($item) {
            return $item->id;
        });
    }
}
