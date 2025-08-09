<?php

namespace App\Services\Auth;

use App\DTO\Auth\AuthDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function authCheck(AuthDTO $authDTO): bool|User
    {
        if(Auth::attempt($authDTO->toArray())) {
            return Auth::user();
        }
        return false;
    }

    public function generateToken(User $user): string
    {
        return $user->createToken('token')->plainTextToken;
    }
}
