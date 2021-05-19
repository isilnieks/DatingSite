<?php

namespace App\Services;

use App\Repositories\PhotosRepository\PhotosRepository;

class PhotoService
{
    private PhotosRepository $repository;

    public function __construct(PhotosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(string $id): void
    {
        $target_dir = "/storage/pictures/";
        $file = $_FILES['my_file']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['my_file']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        define ('SITE_ROOT', realpath(dirname(__DIR__, 2)));
        move_uploaded_file($temp_name, SITE_ROOT."$path_filename_ext");
        //move_uploaded_file($temp_name,$path_filename_ext);
        $path_name = "/pictures/".$filename.".".$ext;
        $this->repository->save($path_name, $id);
        header('Location:/profile');
    }

    public function getPhoto(string $id)
    {
        return $this->repository->getPhoto($id);
    }

}