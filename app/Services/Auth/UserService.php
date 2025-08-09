<?php

namespace App\Services\Auth;

use App\DTO\Auth\UserRegisterDTO;
use App\DTO\Auth\UserUpdateDTO;
use App\Interfaces\Auth\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected UserInterface $userInterface
    )
    {
        //
    }

    public function list(): Collection
    {
        return $this->userInterface->all();
    }
    public function findById(int $id): ?User
    {
        return $this->userInterface->findById($id);
    }
    public function register(array $validated): User
    {
        $validated['password'] = Hash::make($validated['password']);

        return $this->userInterface->create(UserRegisterDTO::fromArray($validated));
    }
    public function update(User $user, UserUpdateDTO $userUpdateDTO): User
    {
        return $this->userInterface->update($user,$userUpdateDTO);
    }

    public function delete(User $user): void
    {
        $this->userInterface->delete($user);
    }
}
