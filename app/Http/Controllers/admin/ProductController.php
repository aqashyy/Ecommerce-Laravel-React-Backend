<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    // This function for return all products
    public function index()
    {
        $products   =   Product::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status'    => 200,
            'data'      =>  $products
        ], 200);
    }
    // This function for store products
    public function store(Request $request)
    {
        // Validate request
        $validator  =   Validator::make($request->all(), [
            'title'         =>  'required',
            'price'         =>  'required',
            'category_id'   =>  'required|exists:categories,id',
            'brand_id'      =>  'required|exists:brands,id',
            'sku'           =>  'required|unique:products,sku',
            'status'        =>  'required',
            'is_featured'   =>  'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ], 400);
        }

        // Store product
        $product                    =   new Product;
        $product->title             =   $request->title;
        $product->price             =   $request->price;
        $product->compare_price     =   $request->compare_price;
        $product->category_id       =   $request->category_id;
        $product->brand_id          =   $request->brand_id;
        $product->sku               =   $request->sku;
        $product->qty               =   $request->qty;
        $product->description       =   $request->description;
        $product->short_description =   $request->short_description;
        $product->barcode           =   $request->barcode;
        $product->status            =   $request->status;
        $product->is_featured       =   $request->is_featured;
        $product->save();

        // Save product images

        if(!empty($request->gallery)) {
            foreach($request->gallery as $key =>  $tempImageId) {
                $tempImage  =   TempImage::find($tempImageId);

                // Large thumbnail
                $extArray   =   explode('.',$tempImage->name);
                $ext        =   end($extArray);

                $imageName  =   $product->id.'-'. time() .'.'.$ext;
                $manager = new ImageManager(Driver::class);
                $img        =   $manager->read(public_path('uploads/temp/'.$tempImage->name));
                $img->scaleDown(1200);
                $img->save(public_path('uploads/products/large/'.$imageName));

                // Small Thumbnail
                $manager = new ImageManager(Driver::class);
                $img        =   $manager->read(public_path('uploads/temp/'.$tempImage->name));
                $img->coverDown(400,460);
                $img->save(public_path('uploads/products/small/'.$imageName));

                // Save product image
                $productImage               =   new ProductImage();
                $productImage->image        =   $imageName;
                $productImage->product_id   =   $product->id;
                $productImage->save();

                if($key == 0) {
                    $product->image     =   $imageName;
                    $product->save();
                }
            }
        }

        return response()->json([
            'status'    => 200,
            'message'   =>  'Product has been created successfully'
        ], 200);
    }
    // This function for return signle product
    public function show($id) {
        $product    =   Product::find($id);

        if ($product == null) {
            return response()->json([
                'status'        =>  404,
                'message'   =>  "Product not found!"
            ], 404);
        }

        return response()->json([
            'status'    => 200,
            'data'      =>  $product
        ], 200);
    }
    // This function for update signle product
    public function update(Request $request, $id)
    {

        $product    =   Product::find($id);

        if ($product == null) {
            return response()->json([
                'status'        =>  404,
                'message'   =>  "Product not found!"
            ], 404);
        }

        // Validate request
        $validator  =   Validator::make($request->all(), [
            'title'         =>  'required',
            'price'         =>  'required',
            'category_id'   =>  'required|exists:categories,id',
            'brand_id'      =>  'required|exists:brands,id',
            'sku'           =>  'required|unique:products,sku,' . $id . ',id',
            'status'        =>  'required',
            'is_featured'   =>  'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ], 400);
        }

        // Store product
        $product->title             =   $request->title;
        $product->price             =   $request->price;
        $product->compare_price     =   $request->compare_price;
        $product->category_id       =   $request->category_id;
        $product->brand_id          =   $request->brand_id;
        $product->sku               =   $request->sku;
        $product->qty               =   $request->qty;
        $product->description       =   $request->description;
        $product->short_description =   $request->short_description;
        $product->image             =   $request->image;
        $product->barcode           =   $request->barcode;
        $product->status            =   $request->status;
        $product->is_featured       =   $request->is_featured;
        $product->save();

        return response()->json([
            'status'    => 200,
            'message'   =>  'Product has been updated successfully'
        ], 200);
    }
    // This function for delete signle product
    public function destroy($id) {
        $product    =   Product::find($id);

        if ($product == null) {
            return response()->json([
                'status'        =>  404,
                'message'   =>  "Product not found!"
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status'    => 200,
            'message'   =>  'Product has been deleted successfully'
        ], 200);
    }
}
