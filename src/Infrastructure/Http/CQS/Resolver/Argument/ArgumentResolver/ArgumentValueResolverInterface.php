<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Argument\ArgumentResolver;


use App\Infrastructure\Http\CQS\Resolver\Metadata\ArgumentMetadata;

interface ArgumentValueResolverInterface
{
    public function supports(ArgumentMetadata $argument): bool;

    public function resolve(ArgumentMetadata $argument): iterable;
}