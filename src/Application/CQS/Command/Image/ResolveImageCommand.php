<?php

declare(strict_types=1);

namespace App\Application\CQS\Command\Image;

use App\Application\CQS\Command\Image\Input\ImageInput;
use App\Domain\Image\Service\ImageService;
use App\Infrastructure\Http\CQS\CommandInterface;
use App\Infrastructure\Http\Response\JsonResponse;
use App\Infrastructure\Http\Response\ResponseInterface;

class ResolveImageCommand implements CommandInterface
{
    public function __construct(
        private readonly ImageService $service
    ) {
    }

    public function __invoke(ImageInput $input): ResponseInterface
    {
        $this->service->resolve($input->id, $input->status);

        return new JsonResponse(['status' => 'ok']);
    }
}