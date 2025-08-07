<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TempImageController extends Controller
{
    public function __construct(protected ProductService $productService) {}
    // This function will store the temp image
    public function store(Request $request): JsonResponse
    {
        // validation request
        $validator = Validator::make($request->all(),[
            'image' =>  'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ],400);
        }
        // Store image
        $tempImage  =   $this->productService->saveTempImage($request->file('image'));

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Image has been uploaded successfully',
            'data'      =>  $tempImage
        ],200);

    }

    // Function to delete temp image with id
    public function destroy($id): JsonResponse
    {

        if(!$this->productService->deleteTempImageById($id)) {
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
