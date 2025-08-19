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
    public function createPicture(array $data): Picture
    {
        $picture = $this->picture->create($data);
        if (!$picture) {
            throw new PictureException('Picture could not be created', 500);
        }
        return $picture;
    }

    public function updatePicture(int $id, array $data)
    {
        $picture = $this->picture->find($id);
        if(!$picture) {
            throw new PictureException('Picture not found.', 404);
        }

        $picture->fill($data);
        $picture->save();
        return $picture;
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