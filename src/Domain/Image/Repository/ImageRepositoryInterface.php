<?php
declare(strict_types=1);

namespace App\Domain\Image\Repository;

use App\Domain\Image\Entity\Image;
use yii\db\ActiveQuery;

interface ImageRepositoryInterface
{
    public function activeQuery(): ActiveQuery;

    public function find(int $id): Image;

    public function get(int $id): ?Image;

    /** @return list<int> */
    public function getAllSavedIds(): array;
}