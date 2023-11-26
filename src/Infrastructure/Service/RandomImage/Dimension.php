<?php
declare(strict_types=1);

namespace App\Infrastructure\Service\RandomImage;

use Webmozart\Assert\Assert;

class Dimension
{
    public function __construct(
        private readonly int $width,
        private readonly int $height,
    )
    {
        Assert::positiveInteger($this->width, 'Width must be positive integer');
        Assert::positiveInteger($this->height, 'Height must be positive integer');
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}