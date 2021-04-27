<?php
namespace App\Controllers;

use App\Services\LikeService;
use App\Services\TwigService;
use Twig\Environment;

class HomeController
{
    private TwigService $environment;
    private LikeService $like;

    public function __construct(LikeService $like)
    {
        $this->environment = new TwigService();
        $this->like = $like;
    }

    public function index()
    {
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        }
        return $this->environment->environment()->render('IndexView.twig', ['id' => $id]);
    }

    public function register()
    {
        return $this->environment->environment()->render('RegisterView.twig');
    }

    public function login()
    {
        return $this->environment->environment()->render('LoginView.twig');
    }

    public function photo()
    {
        return $this->environment->environment()->render('AddPhotoView.twig');
    }

    public function profile()
    {
        return $this->environment->environment()->render('ProfileView.twig', ['session' => $_SESSION]);
    }

    public function matching()
    {
        $users = $this->like->getAllUsers($_SESSION['gender']);
        foreach ($users as $user){
            if(!$this->like->rated(($_SESSION['id'][0]['id']), $user['id'])){
                $unratedUsers[] = $user;
            }
        }
        return $this->environment->environment()->render('MatchingView.twig', ['users' => $unratedUsers]);
    }

}