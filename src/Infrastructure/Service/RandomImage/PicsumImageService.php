<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\RandomImage;

use App\Domain\Image\Repository\ImageRepositoryInterface;
use App\Infrastructure\Service\Integrator\Picsum\Exception\ImageNotFoundException;
use App\Infrastructure\Service\Integrator\Picsum\PicsumIntegrator;

class PicsumImageService implements RandomImageInterface
{
    private const ID_RANGE = [1, 1000];

    public function __construct(
        private readonly ImageRepositoryInterface $repository,
        private readonly PicsumIntegrator $integrator,
    ) {
    }

    public function load(Dimension $dimension): ImageInfoDto
    {
        // I would add a cache here to avoid retrieving a lot of IDs from the database.
        $excludedIds = $this->repository->getAllSavedIds();

        $id = $this->getRandomId($excludedIds);

        $stream = $this->integrator->getImage(
            id: $id,
            width: $dimension->getWidth(),
            height: $dimension->getHeight()
        );

        return new ImageInfoDto($id, $stream);
    }

    public function isImageExists(int $id): bool
    {
        try {
            $this->integrator->info($id);

            return true;
        } catch (ImageNotFoundException) {
            return false;
        }
    }

    private function getRandomId(array $excludedIds): int
    {
        do {
            $id = random_int(...self::ID_RANGE);
        } while (in_array($id, $excludedIds) || !$this->isImageExists($id));

        return $id;
    }
}