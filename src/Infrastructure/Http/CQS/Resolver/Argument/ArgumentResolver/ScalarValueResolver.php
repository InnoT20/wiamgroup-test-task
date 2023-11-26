<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Argument\ArgumentResolver;

use App\Infrastructure\Http\CQS\Resolver\Exception\UnresolvableArgumentException;
use App\Infrastructure\Http\CQS\Resolver\Metadata\ArgumentMetadata;
use Throwable;

final class ScalarValueResolver implements ArgumentValueResolverInterface
{
    private const SCALAR_LIST = ['int', 'bool', 'float', 'string'];


    public function supports(ArgumentMetadata $argument): bool
    {
        return \Yii::$app->request->getQueryParam($argument->getName()) !== null &&
            $argument->getType()->single(fn(string $type) => in_array($type, self::SCALAR_LIST, true));
    }

    public function resolve(ArgumentMetadata $argument): iterable
    {
        $name = $argument->getName();
        $type = $argument->getType();

        $value = \Yii::$app->request->getQueryParam($name);

        $value = match ($type->first()) {
            'int' => filter_var($value, FILTER_VALIDATE_INT),
            'float' => filter_var($value, FILTER_VALIDATE_FLOAT),
            'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            default => $value,
        };

        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === null && !$argument->isNullable()) {
            throw UnresolvableArgumentException::nullArgument($name);
        }

        try {
            yield $value;
        } catch (Throwable $e) {
            throw UnresolvableArgumentException::cannotResolveAttribute($name, $type->first(), $e);
        }
    }
}