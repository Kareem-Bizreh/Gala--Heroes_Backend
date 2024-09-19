<?php

namespace App\Http\Controllers;

use App\Services\Classes\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="get all categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *      response=200, description="Successful get categories"),
     * )
     */
    public function getCategories()
    {
        return response()->json(['categories: ' => $this->categoryService->getCategories()],200);
    }
}
