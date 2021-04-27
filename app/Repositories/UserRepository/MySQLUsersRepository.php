<?php

namespace App\Repositories\UserRepository;

use App\Models\User;
use Medoo\Medoo;

class MySQLUsersRepository implements UsersRepository
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'tinder',
            'server' => '127.0.0.1',
            'username' => 'root',
            'password' => 'root'
        ]);
    }

    public function getAllUsers(string $gender): array
    {
        if ($gender === 'm') {
            $gender = 'f';
        } elseif ($gender === 'f') {
            $gender = 'm';
        }
        return $this->database->select('users',
            [
                'id',
                'username',
                'gender'
            ],
            [
                'gender' => $gender
            ]);
    }

    public function register(User $user): void
    {
        $this->database->insert('users',
            [
                'username' => $user->username(),
                'gender' => $user->gender(),
                'password' => $user->password()
            ]);
    }

    public function password(string $username): array
    {
        return $this->database->select('users',
            [
                'password'
            ],
            [
                'username' => $username,
            ]
        );
    }

    public function login(string $username): array
    {
        return $this->database->select('users',
            [
                'username',
                'gender',
                'password'
            ],
            [
                'username' => $username,
            ]
        );
    }

    public function id(string $username): array
    {
        return $this->database->select('users',
            [
                'id',
            ],
            [
                'username' => $username,
            ]
        );
    }

    public function like(string $id, string $user): void
    {
        $this->database->insert('like',
            [
                'id' => $id,
                'liked' => $user
            ]);
    }

    public function dislike(string $id, string $user): void
    {

        $this->database->insert('dislike',
            [
                'id' => $id,
                'disliked' => $user
            ]);
    }

    public function rated(string $id, string $user): bool
    {
        return($this->database->has('like',
        [
            'id' => $id,
            'liked' => $user
        ])
        ||
            $this->database->has('dislike',
                [
                    'id' => $id,
                    'disliked' => $user
                ])
        );

    }


}