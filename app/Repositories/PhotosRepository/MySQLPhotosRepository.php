<?php

namespace App\Repositories\PhotosRepository;

use Medoo\Medoo;

class MySQLPhotosRepository implements PhotosRepository
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

    public function save(string $file, string $id): void
    {
        if($this->database->has('photos',
            ['id' => $id])){
            $this->database->update('photos',
                [
                    'photo' => $file
                ],
            [
                'id' => $id
            ]);
        }
        else{
        $this->database->insert('photos',
            [
                'id' => $id,
                'photo' => $file
            ]);}
    }

    public function getPhoto(string $id)
    {
        return $this->database->select('photos',
            ['photo'],
            [
                'id' => $id
            ]
        );
    }
}