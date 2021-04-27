<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository\UsersRepository;

class RegisterService
{

    private UsersRepository $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register(string $username, string $password, string $gender): void
    {
        $this->repository->register(new User($username, $gender,   password_hash($password, PASSWORD_DEFAULT), null));
    }

}