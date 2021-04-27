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
        $target_dir = "/storage/";
        $file = $_FILES['my_file']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['my_file']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        define ('SITE_ROOT', realpath(dirname(__DIR__)));
        move_uploaded_file($temp_name, SITE_ROOT."$path_filename_ext");
        //move_uploaded_file($temp_name,$path_filename_ext);
        $this->repository->save($path_filename_ext, $id);
        header('Location:/profile');
    }

}