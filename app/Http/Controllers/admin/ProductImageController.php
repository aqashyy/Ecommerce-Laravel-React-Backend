<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(protected ProductService $productService){}
    public function destroy(int $id): JsonResponse
    {

        if(!$this->productService->deleteProductImageById($id)) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Image not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Image deleted successfully',
        ]);
    }
}
