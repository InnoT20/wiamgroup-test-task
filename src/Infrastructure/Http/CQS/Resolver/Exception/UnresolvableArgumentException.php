<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Exception;

use Throwable;
use yii\web\BadRequestHttpException;

final class UnresolvableArgumentException extends BadRequestHttpException
{
    public static function nullArgument(string $argument): self
    {
        return new self("Argument {$argument} cannot be null.", 400);
    }

    public static function cannotResolveAttribute(string $attribute, string $type, Throwable $previous): self
    {
        return new self(
            "Cannot resolve argument of type '{$type}' with name '{$attribute}'. Reason: '{$previous->getMessage()}'.",
            0,
            $previous
        );
    }

    public static function invalidInputType($expected, $actual, string $varName): self
    {
        return new self("Parameter {$varName} must be of the type {$expected}, {$actual} given", 400);
    }

}