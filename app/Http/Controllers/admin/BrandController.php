<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index() {

        $brands =   Brand::orderBy('created_at','DESC')->get();
        return response()->json([
            'status' => 200,
            'data'  =>  $brands
        ],200);
    }
    public function store(Request $request) {
        $validator  =   Validator::make($request->all(), [
            'name'  =>  'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ],400);
        }

        $barand   =   new Brand;
        $barand->name     =   $request->name;
        $barand->status   =   $request->status;
        $barand->save();

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Brand created successfully',
            'data'      =>  $barand
        ]);
    }

    public function show($id) {
        $barand   =   Brand::find($id);

        if($barand === null) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Brand not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'data'  =>  $barand
        ],200);
    }

    public function update(Request $request, $id) {
        $barand   =   Brand::find($id);

        if($barand === null) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Brand not found',
                'data'  =>  []
            ],404);
        }

        $validator  =   Validator::make($request->all(), [
            'name'  =>  'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ],400);
        }

        $barand->name     =   $request->name;
        $barand->status   =   $request->status;
        $barand->save();

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Brand updated successfully',
            'data'      =>  $barand
        ]);
    }

    public function destroy($id) {
        $barand   =   Brand::find($id);

        if($barand === null) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Brand not found',
                'data'  =>  []
            ],404);
        }

        $barand->delete();

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Brand deleted successfully',
        ]);
    }
}
