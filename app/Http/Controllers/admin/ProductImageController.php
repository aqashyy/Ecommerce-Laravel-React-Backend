<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function destroy($id) {
        $productImg  = ProductImage::find($id);
        // check image is available
        if($productImg === null) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Image not found',
                'data'  =>  []
            ],404);
        }

        // delete image from path
        unlink(public_path('uploads/products/large/'.$productImg->image));
        unlink(public_path('uploads/products/small/'.$productImg->image));
        //  Delete from database
        $productImg->delete();

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Image deleted successfully',
        ]);
    }
}
