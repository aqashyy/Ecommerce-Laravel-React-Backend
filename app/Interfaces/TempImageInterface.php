<?php

namespace App\Interfaces;

use App\DTO\TempImageDTO;
use App\Models\TempImage;

interface TempImageInterface
{
    public function create(TempImageDTO $tempImageDTO): TempImage;
    /**
     * find record with id
     */
    public function find(int $id): ?TempImage;

    public function delete(TempImage $tempImage): void;
}
