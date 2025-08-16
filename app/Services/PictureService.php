<?php

namespace App\Services;

use App\Errors\PictureException;
use App\Models\Picture;

class PictureService
{
    private Picture $picture;

    public function __construct(Picture $picture)
    {
        $this->picture = $picture;
    }
    public function createPicture(array $data)
    {
        $picture = $this->picture->fill($data);
        $newPicture = $picture->save();
        if (!$newPicture) {
            throw new PictureException('Picture could not be created', 500);
        }
        return $picture;
    }

    public function updatePicture(int $id, array $data)
    {
        // Business logic for updating a picture can be added here
    }

    public function deletePicture(int $id)
    {
        // Business logic for deleting a picture can be added here
    }

    public function getPicture(int $id)
    {
        // Business logic for retrieving a picture can be added here
    }

    public function getAllPictures()
    {
        // Business logic for retrieving all pictures can be added here
    }
}