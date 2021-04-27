<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository\UsersRepository;


class LoginService
{
    private UsersRepository $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(string $username, string $password)
    {
        if(password_verify($password ,$this->repository->password($username)[0]["password"]) && isset($this->repository->login($username)[0]["username"]))
        {
            $data = $this->repository->login($username)[0];
            $user = new User(
                $data['username'],
                $data['gender'],
                $data['password'],
                $data['id']
            );
            return $user;
        }

    }

    public function id(string $username): array
    {
        return $this->repository->id($username);
    }

}