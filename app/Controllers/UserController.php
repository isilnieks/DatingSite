<?php

namespace App\Controllers;

use App\Services\LikeService;
use App\Services\LoginService;
use App\Services\PhotoService;
use App\Services\RegisterService;


class UserController
{
    private RegisterService $register;
    private LoginService $login;
    private PhotoService $photo;
    private LikeService $like;


    public function __construct(RegisterService $register, LoginService $login, PhotoService $photo, LikeService $like)
    {
        $this->register = $register;
        $this->login = $login;
        $this->photo = $photo;
        $this->like = $like;
    }

    public function register(): void
    {
        $this->register->register($_POST['username'], $_POST['password'], $_POST['gender']);
        header('Location:/');
    }

    public function login()
    {
        $user = $this->login->login($_POST['username'],$_POST['password']);
        if(is_null($user)){
            $_SESSION['_flash'] = 'Wrong username or password!';
            header('Location:/login');
        }else {
            $id = $this->login->id($_POST['username']);
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['gender'] = $user->gender();
            header('Location:/');
        }
    }

    public function logout()
    {
        session_destroy ();
        session_start();
        header('Location:/');
    }

    public function savePhoto()
    {
        $this->photo->save($_SESSION['id'][0]['id']);
    }

    public function like()
    {
        $this->like->like($_SESSION['id'][0]['id'], $_POST['like']);
        header('Location:/matching');
    }

    public function dislike()
    {
        $this->like->dislike($_SESSION['id'][0]['id'], $_POST['dislike']);
        header('Location:/matching');
    }

}