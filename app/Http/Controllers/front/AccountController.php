<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function register(Request $request) {

        $rules = [
            'name'  => 'required|max:255',
            'email' =>  'required|email|unique:users,email',
            'password'  =>  'required|min:8'
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ],400);
        }

        $user = new User();
        $user->name     =   $request->input('name');
        $user->email    =   $request->input('email');
        $user->role     =   'customer';
        $user->password =   Hash::make($request->input('password'));
        $user->save();


        return response()->json([
            'status'    =>  200,
            'message'    =>  "Registration completed successfully"
        ],200);

    }

    public function authenticate(Request $request) {
        $validator  =   Validator::make($request->all(),[
            'email'     =>  'required|email',
            'password'  =>      'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ],400);
        }
        if(Auth::attempt(['email'   =>  $request->input('email'), 'password'  =>  $request->input('password')])){
            $user   =   User::find(Auth::user()->id);

            $token  =   $user->createToken('token')->plainTextToken;
            return response()->json([
                'status'    =>  200,
                'token'     =>  $token,
                'id'        =>  $user->id,
                'name'      =>  $user->name
            ],200);

        }else{
            return response()->json([
                'status'    =>  401,
                'message'   =>  'Invalid email/password!'
            ],401);
        }
    }
    public function myOrders(Request $request) {
        $order = Order::where('user_id', $request->user()->id)
                        ->get();

        return response()->json([
            'status'    =>  200,
            'data'      =>  $order
        ],200);
    }
    public function updateProfile(Request $request) {
        $user = User::find($request->user()->id);

        if($user == null) {
            return response()->json([
                'status' => 404,
                'message'   =>  'User Not Found!'
            ],404);
        }

        $validator = Validator::make($request->all(),[
            'name'      =>  'required',
            'email'     =>  'required|unique:users,email,'.$request->User()->id,
            'mobile'    =>  'required',
            'address'   =>  'required',
            'city'      =>  'required',
            'state'     =>  'required',
            'zip'       =>  'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    =>  400,
                'errors'    =>  $validator->errors()
            ],400);
        }

        $user->name         =   $request->name;
        $user->email        =   $request->email;
        $user->address      =   $request->address;
        $user->mobile       =   $request->mobile;
        $user->state        =   $request->state;
        $user->city         =   $request->city;
        $user->zip          =   $request->zip;
        $user->save();

        return response()->json([
            'status'    =>  200,
            'data'      =>  $user,
            'message'   =>  'Profile updated successfully'
        ],200);
    }

    public function getProfile(Request $request) {
        $user = $request->user();

        if($user == null) {
            return response()->json([
                'status' => 404,
                'message'   =>  'User Not Found!'
            ],404);
        }
        return response()->json([
            'status'    =>  200,
            'data'      =>  $user,
        ],200);
    }
}
