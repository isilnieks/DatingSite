<?php
namespace App\Controllers;

use App\Services\LikeService;
use App\Services\PhotoService;
use App\Services\TwigService;
use Twig\Environment;

class HomeController
{
    private TwigService $environment;
    private LikeService $like;
    private PhotoService $photo;

    public function __construct(LikeService $like, PhotoService $photo)
    {
        $this->environment = new TwigService();
        $this->like = $like;
        $this->photo = $photo;
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
        $photo = $this->photo->getPhoto($_SESSION['id'][0]['id']);
        return $this->environment->environment()->render('ProfileView.twig',
            ['session' => $_SESSION, 'photo' => $photo[0]['photo']]);
    }

    public function matching()
    {
        $users = $this->like->getAllUsers($_SESSION['gender']);
        foreach ($users as $user){
            if(!$this->like->rated(($_SESSION['id'][0]['id']), $user['id'])){
                $unratedUsers[] = $user;
                $photos[$user['id']] = $this->photo->getPhoto($user['id'])[0]['photo'];
            }
        }

        return $this->environment->environment()->render('MatchingView.twig',
            [
                'users' => $unratedUsers,
                'photos' => $photos
            ]);
    }

    public function matches()
    {
       $matches = $this->like->matches($_SESSION['gender'], $_SESSION['id'][0]['id']);

       foreach($matches as $match){
           $photos[$match['id']] = $this->photo->getPhoto($match['id'])[0]['photo'];
           $users[] = $match;
       }

       return $this->environment->environment()->render('MatchesView.twig',
       [
           'photos' => $photos,
           'users' => $users
       ]);

    }

}