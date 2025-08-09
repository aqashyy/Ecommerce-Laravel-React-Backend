<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\UserRegisterDTO;
use App\DTO\Auth\UserUpdateDTO;
use App\Interfaces\Auth\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserInterface
{
    public function all(): Collection
    {
        return User::all();
    }
    public function findById(int $id): ?User
    {
        $user   =   User::find($id);
        if(!$user) return null;
        return $user;
    }
    public function create(UserRegisterDTO $userRegisterDTO): User
    {
        return User::create($userRegisterDTO->toArray());
    }
    public function update(User $user, UserUpdateDTO $userUpdateDTO): User
    {
        $user->update($userUpdateDTO->toArray());
        
        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
