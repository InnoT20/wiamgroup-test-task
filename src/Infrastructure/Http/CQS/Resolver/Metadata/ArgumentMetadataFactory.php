<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Metadata;

use App\Infrastructure\Http\CQS\CommandInterface;
use App\Infrastructure\Http\CQS\CqsInterface;
use App\Infrastructure\Http\CQS\QueryInterface;
use App\Infrastructure\Http\CQS\Resolver\Exception\ArgumentMustHaveDeclaredTypeException;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
use RuntimeException;

final class ArgumentMetadataFactory implements ArgumentMetadataFactoryInterface
{
    public function create(CqsInterface $class): array
    {
        [$reflection, $reflectionMethod] = $this->load($class);

        $arguments = [];

        foreach ($reflectionMethod->getParameters() as $parameter) {
            if (null === $parameter->getType()) {
                throw new ArgumentMustHaveDeclaredTypeException($reflection->getShortName(), $parameter->getName());
            }

            $arguments[] = new ArgumentMetadata(
                name: $parameter->getName(),
                type: $this->getArgumentType($parameter->getType()),
                hasDefaultValue: $parameter->isDefaultValueAvailable(),
                defaultValue: $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null,
                isNullable: $parameter->allowsNull()
            );
        }

        return $arguments;
    }

    private function getArgumentType(ReflectionType $type): ArgumentTypeMetadata
    {
        $reflectionTypes = match (true) {
            $type instanceof ReflectionNamedType => [$type->getName()],
            $type instanceof ReflectionUnionType => array_map(fn(ReflectionNamedType $t) => $t->getName(),
                $type->getTypes()),
            $type instanceof ReflectionIntersectionType => throw new RuntimeException(
                'Intersection type is not supported'
            )
        };

        return new ArgumentTypeMetadata($reflectionTypes);
    }

    private function load(CqsInterface $class): array
    {
        $reflection = new ReflectionClass($class);

        try {
            $reflectionMethod = $reflection->getMethod('__invoke');
        } catch (\ReflectionException) {
            throw new RuntimeException(sprintf('Class %s must have __invoke method', $reflection->getShortName()));
        }

        return [$reflection, $reflectionMethod];
    }
}