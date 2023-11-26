<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Metadata;


final class ArgumentMetadata
{
    public function __construct(
        private readonly string $name,
        private readonly ArgumentTypeMetadata $type,
        private readonly bool $hasDefaultValue,
        private readonly mixed $defaultValue,
        private bool $isNullable
    ) {
        $this->isNullable = $isNullable || ($hasDefaultValue && null === $defaultValue);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ArgumentTypeMetadata
    {
        return $this->type;
    }

    public function hasDefaultValue(): bool
    {
        return $this->hasDefaultValue;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }
}