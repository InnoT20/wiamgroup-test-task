<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\RandomImage;

use Psr\Http\Message\StreamInterface;

final class ImageInfoDto
{
    public function __construct(
        public readonly int $id,
        public readonly StreamInterface $stream,
    ) {
    }
}