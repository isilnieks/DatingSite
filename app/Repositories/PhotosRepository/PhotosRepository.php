<?php

namespace App\Repositories\PhotosRepository;

interface PhotosRepository
{
    public function save(string $file, string $id): void;
    public function getPhoto(string $id);
}