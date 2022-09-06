<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoriesService
{
    private Collection $allCategories;

    public function __construct()
    {
        $this->allCategories = Category::all();
    }

    public function all(): Collection
    {
        return $this->allCategories;
    }
}
