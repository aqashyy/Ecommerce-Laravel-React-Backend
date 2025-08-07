<?php

namespace App\Http\Controllers\Admin;

use App\DTO\ProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}
    /**
     * This function for return all products
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status'    => 200,
            'data'      =>  $this->productService->list()
        ], 200);
    }
    /**
     * This function for store products
     * @param \App\Http\Requests\Product\StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $productDTO =   ProductDTO::fromArray($request->validated());

        $this->productService->create($productDTO);

        return response()->json([
            'status'    => 200,
            'message'   =>  'Product has been created successfully'
        ], 200);
    }
    /**
     * This function for return signle product
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product    =   $this->productService->find($id);

        if (!$product) {
            return response()->json([
                'status'        =>  404,
                'message'   =>  "Product not found!"
            ], 404);
        }
        $productSizes = $product->product_sizes->pluck('size_id');
        return response()->json([
            'status'        => 200,
            'data'          =>  $product,
            'productSizes'  =>  $productSizes
        ], 200);
    }
    /**
     * This function for update signle product
     * @param \App\Http\Requests\Product\UpdateRequest $request
     * @param mixed $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $productDTO =   ProductDTO::fromArray($request->validated());
        $product    =   $this->productService->update($id, $productDTO);

        if (!$product) {
            return response()->json([
                'status'        =>  404,
                'message'   =>  "Product not found!"
            ], 404);
        }

        return response()->json([
            'status'    => 200,
            'message'   =>  'Product has been updated successfully'
        ], 200);
    }
    /**
     * This function for delete signle product
     * @param mixed $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {

        if (!$this->productService->delete($id)) {

            return response()->json([
                'status'        =>  404,
                'message'   =>  "Product not found!"
            ], 404);

        }

        return response()->json([
            'status'    => 200,
            'message'   =>  'Product has been deleted successfully'
        ], 200);
    }
    /**
     * Save product image
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function saveProductImage(Request $request): JsonResponse
    {
        // validation request
        $validator = Validator::make($request->all(), [
            'image' =>  'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ], 400);
        }

        $product        =   $this->productService->find($request->product_id);

        $image          = $request->file('image');
        $imageName      =   $request->product_id . '-' . time() . '.' . $image->extension();

        $productImage   =   $this->productService->saveProductImage($product, $image->getPathname(), $imageName);

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Image has been uploaded successfully',
            'data'      =>  $productImage
        ], 200);
    }
    /**
     * Set Product default image
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function setDefaultProductImage(Request $request): JsonResponse {

        $validator = Validator::make($request->all(), [
            'product_id'    =>  'required|exists:products',
            'image'         =>  'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ], 400);
        }
        // send to product service
        $this->productService->setDefaultImage($request->product_id,$request->image);

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Product default image has been updated successfully',
        ], 200);
    }
}
