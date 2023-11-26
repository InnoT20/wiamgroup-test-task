<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver\Argument\ArgumentResolver;

use App\Infrastructure\Helpers\ValidationHelper;
use App\Infrastructure\Http\CQS\Resolver\Metadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use yii\web\UnprocessableEntityHttpException;

final class InputValueResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function supports(ArgumentMetadata $argument): bool
    {
        return $argument->getType()->single(fn(string $type) => str_ends_with($type, 'Input'));
    }

    public function resolve(ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType()->first();

        $content = \Yii::$app->request->getRawBody();

        yield $this->deserialize($type, $content);
    }

    private function deserialize(string $type, string $content): mixed
    {
        try {
            $deserialized = $this->serializer->deserialize($content, $type, 'json');
        } catch (NotNormalizableValueException $exception) {
            throw new UnprocessableEntityHttpException([$this->convertExceptionToMessage($exception)]);
        }

        if (null !== $deserialized) {
            $this->validate($deserialized);
        }

        return $deserialized;
    }

    private function validate($input): void
    {
        if (\count($errors = $this->validator->validate($input)) > 0) {
            throw new UnprocessableEntityHttpException(ValidationHelper::formatViolationErrors($errors));
        }
    }

    private function convertExceptionToMessage(NotNormalizableValueException $exception): string
    {
        return sprintf(
            "%s: must be of the type %s",
            $exception->getPath(),
            implode(', ', $exception->getExpectedTypes())
        );
    }
}