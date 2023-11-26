<?php

declare(strict_types=1);

namespace App\Infrastructure\Helpers;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationHelper
{
    public static function formatViolationErrors(ConstraintViolationListInterface $list): array
    {
        $errorsArr = [];

        /** @var ConstraintViolation $e */
        foreach ($list as $e) {
            $prop = $e->getPropertyPath();
            $errorsArr[] = null !== $prop ? "{$prop}: {$e->getMessage()}" : $e->getMessage();
        }

        return $errorsArr;
    }
}