<?php

declare(strict_types=1);

namespace App\Application\Http;

use App\Application\CQS\Command\Image\ResolveImageCommand;
use App\Application\CQS\Query\Image\LoadRandomImageQuery;
use App\Infrastructure\Http\Controller;
use App\Infrastructure\Http\JsonControllerInterface;

final class ImageController extends Controller implements JsonControllerInterface
{
    public function actions(): array
    {
        return [
            'index' => fn(string $id) => $this->execute($id, LoadRandomImageQuery::class),
            'resolve' => fn(string $id) => $this->execute($id, ResolveImageCommand::class),
        ];
    }
}