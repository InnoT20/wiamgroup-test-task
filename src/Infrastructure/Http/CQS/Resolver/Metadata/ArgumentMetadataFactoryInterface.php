<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Metadata;

use App\Infrastructure\Http\CQS\CommandInterface;
use App\Infrastructure\Http\CQS\CqsInterface;
use App\Infrastructure\Http\CQS\QueryInterface;

interface ArgumentMetadataFactoryInterface
{
    /**
     * @param CqsInterface $class
     * @return list<ArgumentMetadata>
     */
    public function create(CqsInterface $class): array;
}