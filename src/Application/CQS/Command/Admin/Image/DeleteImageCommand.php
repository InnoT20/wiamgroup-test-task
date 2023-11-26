<?php

declare(strict_types=1);

namespace App\Application\CQS\Command\Admin\Image;

use App\Domain\Image\Repository\ImageRepositoryInterface;
use App\Infrastructure\Http\CQS\CommandInterface;
use App\Infrastructure\Http\Response\RedirectResponse;
use App\Infrastructure\Http\Response\ResponseInterface;

final class DeleteImageCommand implements CommandInterface
{
    public function __construct(private readonly ImageRepositoryInterface $repository)
    {
    }

    public function __invoke(string $token, int $id): ResponseInterface
    {
        $image = $this->repository->find($id);

        $image->delete();

        return new RedirectResponse(['index', 'token' => $token]);
    }
}