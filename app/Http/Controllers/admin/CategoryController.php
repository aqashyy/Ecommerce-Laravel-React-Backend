<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index() {

        $categories =   Category::orderBy('created_at','DESC')->get();
        return response()->json([
            'status' => 200,
            'data'  =>  $categories
        ],200);
    }
}
