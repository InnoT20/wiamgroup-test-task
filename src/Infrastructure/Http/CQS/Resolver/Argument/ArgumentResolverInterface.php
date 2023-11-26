<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Argument;

use App\Infrastructure\Http\CQS\CommandInterface;
use App\Infrastructure\Http\CQS\CqsInterface;
use App\Infrastructure\Http\CQS\QueryInterface;

interface ArgumentResolverInterface
{
    public function getArguments(CqsInterface $instance): array;
}