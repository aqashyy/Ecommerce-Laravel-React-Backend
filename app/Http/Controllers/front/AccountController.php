<?php

namespace App\Http\Controllers\front;

use App\DTO\Auth\AuthDTO;
use App\DTO\Auth\UserUpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Auth\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function __construct(
        protected UserService $userService,
        protected AuthService $authService
    ) {}

    public function register(StoreRequest $request): JsonResponse {

        // register user
        $this->userService->register($request->validated());

        return response()->json([
            'status'    =>  200,
            'message'    =>  "Registration completed successfully"
        ],200);

    }

    public function authenticate(Request $request): JsonResponse {
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
        if($user = $this->authService->authCheck(AuthDTO::fromArray($request->only('email','password')))){

            return response()->json([
                'status'    =>  200,
                'token'     =>  $this->authService->generateToken($user),
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
    public function myOrders(Request $request): JsonResponse {
        $order = Order::where('user_id', $request->user()->id)
                        ->get();

        return response()->json([
            'status'    =>  200,
            'data'      =>  $order
        ],200);
    }
    public function updateProfile(UpdateRequest $request): JsonResponse {
        $user = $this->userService->findById($request->user()->id);

        if(!$user) {
            return response()->json([
                'status' => 404,
                'message'   =>  'User Not Found!'
            ],404);
        }

        $user = $this->userService->update($user,UserUpdateDTO::fromArray($request->validated()));

        return response()->json([
            'status'    =>  200,
            'data'      =>  $user,
            'message'   =>  'Profile updated successfully'
        ],200);
    }

    public function getProfile(Request $request): JsonResponse {
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
