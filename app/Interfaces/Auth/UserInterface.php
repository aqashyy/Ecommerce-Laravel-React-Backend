<?php

namespace App\Interfaces\Auth;

use App\DTO\Auth\UserRegisterDTO;
use App\DTO\Auth\UserUpdateDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserInterface
{
    public function all(): Collection;

    public function findById(int $id): ?User;

    public function create(UserRegisterDTO $userRegisterDTO): User;

    public function update(User $user, UserUpdateDTO $userUpdateDTO): User;

    public function delete(User $user): void;
}
