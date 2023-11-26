<?php
declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Exception;

use Throwable;

final class ArgumentMustHaveDeclaredTypeException extends \RuntimeException
{
    public function __construct(string $class, string $argumentName, ?Throwable $previous = null)
    {
        parent::__construct("Argument {$argumentName} must have declared type in {$class}", 0, $previous);
    }
}