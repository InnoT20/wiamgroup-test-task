<?php

declare(strict_types=1);

namespace App\Domain\Image\Service;

use App\Domain\Image\Entity\Image;
use App\Domain\Image\Enum\StatusEnum;
use App\Domain\Image\Repository\ImageRepositoryInterface;

final class ImageService
{
    public function __construct(private readonly ImageRepositoryInterface $repository)
    {
    }

    public function resolve(int $id, StatusEnum $status): void
    {
        $image = $this->repository->get($id);

        if ($image !== null) {
            return;
        }

        $image = new Image();
        $image->imageId = $id;
        $image->status = $status;
        $image->save();
    }
}