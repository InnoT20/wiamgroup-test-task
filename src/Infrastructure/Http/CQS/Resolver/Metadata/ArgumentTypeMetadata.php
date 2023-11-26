<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Metadata;


final class ArgumentTypeMetadata
{
    /**
     * @param list<string> $types
     */
    public function __construct(private array $types)
    {
    }

    public function types(): array
    {
        return $this->types;
    }

    public function single(callable $fn): bool
    {
        if (count($this->types) > 1) {
            return false;
        }

        return $fn($this->types[0]);
    }

    public function each(callable $fn): bool
    {
        foreach ($this->types as $type) {
            if (!$fn($type)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param class-string $class
     */
    public function singleSubclassOf(string $class): bool
    {
        return $this->single(fn(string $type) => is_subclass_of($type, $class));
    }

    /**
     * @param class-string $class
     */
    public function eachSubclassOf(string $class): bool
    {
        return $this->each(fn(string $type) => is_subclass_of($type, $class));
    }

    public function first(): string
    {
        return $this->types[0];
    }
}