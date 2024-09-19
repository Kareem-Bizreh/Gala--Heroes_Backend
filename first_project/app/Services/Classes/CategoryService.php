<?php

namespace App\Services\Classes;

use App\Models\Category;
use App\Services\Interfaces\CategoryServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService implements CategoryServiceInterface
{

    /**
     * get all categories
     *
     * @throws ModelNotFoundException
     */
    public function getCategories()
    {
        $categories = Category::all(['id', 'name_ar', 'name_en']);
        return $categories;
    }
}
