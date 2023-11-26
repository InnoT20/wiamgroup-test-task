<?php

namespace App\Application\Http\Admin;

use App\Application\CQS\Command\Admin\Image\DeleteImageCommand;
use App\Application\CQS\Query\Admin\Image\ImageListQuery;
use App\Infrastructure\Http\Behaviour\QueryTokenAuth;
use App\Infrastructure\Http\Controller;

class ImageController extends Controller
{

    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => QueryTokenAuth::class,
                ],
            ]
        );
    }

    public function actions(): array
    {
        return [
            'index' => fn(string $id) => $this->execute($id, ImageListQuery::class),
            'delete' => fn(string $id) => $this->execute($id, DeleteImageCommand::class),
        ];
    }
}
