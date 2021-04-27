<?php

namespace App\Repositories\UserRepository;

use App\Models\User;

interface UsersRepository
{
    public function getAllUsers(string $gender):array;
    public function register(User $user): void;
    public function password(string $username): array;
    public function login(string $username): array;
    public function id(string $username): array;
    public function like(string $id, string $user): void;
    public function dislike(string $id, string $user): void;
    public function rated(string $id, string $user): bool;

}