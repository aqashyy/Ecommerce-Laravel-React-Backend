<?php

namespace App\Repositories;

use App\DTO\TempImageDTO;
use App\Interfaces\TempImageInterface;
use App\Models\TempImage;

class TempImageRepository implements TempImageInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function create(TempImageDTO $tempImageDTO): TempImage
    {
        return TempImage::create($tempImageDTO->toArray());
    }
    /**
     * Find record with id.
     */
    public function find(int $id): ?TempImage
    {
        return TempImage::find($id);
    }

    public function delete(TempImage $tempImage): void
    {
        // delete image from path
        unlink(public_path('uploads/temp/'.$tempImage->name));
        unlink(public_path('uploads/temp/thumb/'.$tempImage->name));

        $tempImage->delete();
    }
}
