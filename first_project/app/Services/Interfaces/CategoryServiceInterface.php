<?php
namespace App\Services\Interfaces;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface CategoryServiceInterface
{
    /**
     * get all categories
     *
     * @throws ModelNotFoundException
     */
    public function getCategories();
}
