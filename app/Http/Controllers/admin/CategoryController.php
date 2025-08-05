<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {

    }
    //
    public function index(): JsonResponse {

        return response()->json([
            'status' => 200,
            'data'  =>  $this->categoryService->list()
        ],200);
    }
    /*  Function for store categories */
    public function store(StoreRequest $request): JsonResponse {

        $categoryDTO    =   CategoryDTO::fromArray($request->validated());

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Category created successfully',
            'data'      =>  $this->categoryService->create($categoryDTO)
        ]);
    }
    /* FUNCTION FOR SHOW CATEGORY */
    public function show(int $id): JsonResponse {
        $category   =   $this->categoryService->find($id);

        if(!$category) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Category not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'data'  =>  $category
        ],200);
    }
/* FUNCTION FOR UPDATE CATEGORY */
    public function update(UpdateRequest $request,int $id): JsonResponse {
        $categoryDTO    =   CategoryDTO::fromArray($request->validated());

        $category   =   $this->categoryService->update($id,$categoryDTO);

        if(!$category) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Category not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Category updated successfully',
            'data'      =>  $category
        ]);
    }
/* FUNCTION FOR DESTROY / DELETE CATEGORY */
    public function destroy(int $id): JsonResponse {

        if(!$this->categoryService->delete($id)) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Category not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Category deleted successfully',
        ]);
    }
}
