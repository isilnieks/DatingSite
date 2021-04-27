<?php

namespace App\Services;

use App\Repositories\UserRepository\UsersRepository;

class LikeService
{

    private UsersRepository $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function like(string $id, string $user): void
    {
        $this->repository->like($id, $user);
    }

    public function dislike(string $id, string $user): void
    {
        $this->repository->dislike($id, $user);
    }

    public function rated(string $id, string $user): bool
    {
        return $this->repository->rated($id, $user);
    }

    public function getAllUsers(string $gender): array
    {
        return $this->repository->getAllUsers($gender);
    }
}