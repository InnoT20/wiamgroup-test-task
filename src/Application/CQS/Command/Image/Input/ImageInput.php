<?php

declare(strict_types=1);

namespace App\Application\CQS\Command\Image\Input;

use App\Domain\Image\Enum\StatusEnum;

class ImageInput
{
    public function __construct(
        public readonly int $id,
        public readonly StatusEnum $status,
    ) {
    }


}