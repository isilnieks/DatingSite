<?php

namespace App\Models;

class User
{
    private string $username;
    private string $gender;
    private string $password;
    private ?int $id;

    public function __construct(
        string $username,
        string $gender,
        string $password,
        ?int $id
    )
    {
        $this->username = $username;
        $this->gender = $gender;
        $this->password = $password;
        $this->id = $id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function gender(): string
    {
        return $this->gender;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function id(): int
    {
        return $this->id;
    }
}
