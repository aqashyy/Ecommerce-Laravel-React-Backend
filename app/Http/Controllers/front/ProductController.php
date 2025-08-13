<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected BrandService $brandService
    ) {}

    public function getProducts(Request $request): JsonResponse {

        $products = $this->productService->filterProduts($request);

        return response()->json([
            'status'    => 200,
            'data'  =>  $products
        ],200);

    }

    public function latestProducts(): JsonResponse {

        $products = $this->productService->getLatestProduct();

        return response()->json([
            'status'    => 200,
            'data'  =>  $products
        ],200);
    }
    public function featuredProducts(): JsonResponse {

        $products = $this->productService->getFeaturedProduct();

        return response()->json([
            'status'    => 200,
            'data'  =>  $products
        ],200);
    }
    public function getCategories(): JsonResponse {

        return response()->json([
            'status'    => 200,
            'data'  =>  $this->categoryService->getActive()
        ],200);
    }
    public function getBrands(): JsonResponse {

        return response()->json([
            'status'    => 200,
            'data'  =>  $this->brandService->getActive()
        ],200);
    }
    public function getProduct($id): JsonResponse {

        $product    =   $this->productService->find($id);
        if( !$product ) {
            return response()->json([
                'status'    => 404,
                'message'  =>  "Product not found"
            ],404);
        }

        return response()->json([
            'status'    => 200,
            'data'  =>  $product
        ],200);
    }
}
