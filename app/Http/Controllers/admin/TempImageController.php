<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TempImageController extends Controller
{
    // This function will store the temp image
    public function store(Request $request) {
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

        $tempImage = new TempImage();
        $tempImage->name    =    "Dummy";
        $tempImage->save();

        $image = $request->file('image');
        $imageName  =   time().'.'.$image->extension();
        $image->move(public_path('uploads/temp'),$imageName);

        $tempImage->name    =   $imageName;
        $tempImage->save();

        // Save Image thumbnail
        $manager = new ImageManager(Driver::class);
        $img = $manager->read(public_path('uploads/temp/'.$imageName));
        $img->coverDown(400, 450);
        $img->save(public_path('uploads/temp/thumb/'.$imageName));

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Image has been uploaded successfully',
            'data'      =>  $tempImage
        ],200);

    }

    // Function to delete temp image with id
    public function destroy($id){
        $tempImage  =   TempImage::find($id);

        // check image is available
        if($tempImage === null) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Image not found',
                'data'  =>  []
            ],404);
        }
        // delete image from path
        unlink(public_path('uploads/temp/'.$tempImage->name));
        unlink(public_path('uploads/temp/thumb/'.$tempImage->name));
        //  Delete from database
        $tempImage->delete();

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Image deleted successfully',
        ]);


    }
}
