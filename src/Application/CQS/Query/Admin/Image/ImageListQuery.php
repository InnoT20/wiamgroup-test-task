<?php

declare(strict_types=1);

namespace App\Application\CQS\Query\Admin\Image;

use App\Domain\Image\Repository\ImageRepositoryInterface;
use App\Infrastructure\Http\CQS\QueryInterface;
use App\Infrastructure\Http\Response\ResponseInterface;
use App\Infrastructure\Http\Response\ViewResponse;
use yii\data\ActiveDataProvider;

final class ImageListQuery implements QueryInterface
{
    public function __construct(
        private readonly ImageRepositoryInterface $repository
    ) {
    }

    public function __invoke(): ResponseInterface
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->repository->activeQuery(),
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return new ViewResponse('@views/admin/index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}