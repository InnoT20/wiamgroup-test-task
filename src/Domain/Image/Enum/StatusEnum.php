<?php
declare(strict_types=1);

namespace App\Domain\Image\Enum;

enum StatusEnum: string
{
    case APPLY = 'apply';
    case REJECT = 'reject';
}
