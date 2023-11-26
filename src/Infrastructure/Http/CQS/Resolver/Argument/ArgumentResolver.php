<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Argument;

use App\Infrastructure\Http\CQS\CommandInterface;
use App\Infrastructure\Http\CQS\CqsInterface;
use App\Infrastructure\Http\CQS\QueryInterface;
use App\Infrastructure\Http\CQS\Resolver\Argument\ArgumentResolver\ArgumentValueResolverInterface;
use App\Infrastructure\Http\CQS\Resolver\Metadata\ArgumentMetadataFactoryInterface;

final class ArgumentResolver implements ArgumentResolverInterface
{
    /**
     * @param ArgumentMetadataFactoryInterface $argumentMetadataFactory
     * @param list<ArgumentValueResolverInterface> $argumentResolvers
     */
    public function __construct(
        private readonly ArgumentMetadataFactoryInterface $argumentMetadataFactory,
        private readonly array $argumentResolvers
    ) {
    }

    public function getArguments(CqsInterface $instance): array
    {
        $arguments = [];

        $metadataArguments = $this->argumentMetadataFactory->create($instance);

        foreach ($metadataArguments as $argument) {
            foreach ($this->argumentResolvers as $resolver) {
                if (!$resolver->supports($argument)) {
                    continue;
                }

                $resolved = $resolver->resolve($argument);

                $atLeastOne = false;
                foreach ($resolved as $append) {
                    $atLeastOne = true;
                    $arguments[] = $append;
                }

                if (!$atLeastOne) {
                    throw new \InvalidArgumentException(
                        sprintf('"%s::resolve()" must yield at least one value.', get_debug_type($resolver))
                    );
                }

                continue 2;
            }
        }

        return $arguments;
    }
}