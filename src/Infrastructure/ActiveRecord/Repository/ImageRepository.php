<?php

declare(strict_types=1);

namespace App\Infrastructure\ActiveRecord\Repository;

use App\Domain\Image\Entity\Image;
use App\Domain\Image\Repository\ImageRepositoryInterface;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

class ImageRepository implements ImageRepositoryInterface
{
    public function activeQuery(): ActiveQuery
    {
        return Image::find();
    }

    public function get(int $id): ?Image
    {
        return Image::findOne($id);
    }

    public function getAllSavedIds(): array
    {
        return Image::find()->select('imageId')->column();
    }

    public function find(int $id): Image
    {
        $image = $this->get($id);

        if ($image === null) {
            throw new NotFoundHttpException('Image not found');
        }

        return $image;
    }
}