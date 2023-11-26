<?php
declare(strict_types=1);

namespace App\Infrastructure\Service\RandomImage;

interface RandomImageInterface
{
    public function load(Dimension $dimension): ImageInfoDto;
}