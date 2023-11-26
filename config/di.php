<?php

use App\Application\CQS\Query\Image\LoadRandomImageQuery;
use App\Domain\Image\Repository\ImageRepositoryInterface;
use App\Infrastructure\ActiveRecord\Repository\ImageRepository;
use App\Infrastructure\Http\Behaviour\QueryTokenAuth;
use App\Infrastructure\Http\CQS\Resolver\Argument\ArgumentResolver;
use App\Infrastructure\Http\CQS\Resolver\Argument\ArgumentResolverInterface;
use App\Infrastructure\Http\CQS\Resolver\Metadata\ArgumentMetadataFactory;
use App\Infrastructure\Http\CQS\Resolver\Metadata\ArgumentMetadataFactoryInterface;
use App\Infrastructure\Service\Integrator\Picsum\PicsumIntegrator;
use App\Infrastructure\Service\RandomImage\PicsumImageService;
use App\Infrastructure\Service\RandomImage\RandomImageInterface;
use Symfony\Component\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;
use yii\di\Instance;

$container = Yii::$container;

// Serializer
$container->set(Serializer\SerializerInterface::class, [
    'class' => Serializer\Serializer::class,
    '__construct()' => [
        [
            Instance::ensure(Serializer\Normalizer\BackedEnumNormalizer::class),
            Instance::ensure(Serializer\Normalizer\ArrayDenormalizer::class),
            Instance::ensure(Serializer\Normalizer\ObjectNormalizer::class),
            Instance::ensure(Serializer\Normalizer\PropertyNormalizer::class),
            Instance::ensure(Serializer\Normalizer\DateTimeNormalizer::class),
            Instance::ensure(Serializer\Normalizer\DateTimeZoneNormalizer::class),
            Instance::ensure(Serializer\Normalizer\DateIntervalNormalizer::class),
            Instance::ensure(Serializer\Normalizer\GetSetMethodNormalizer::class),
            Instance::ensure(Serializer\Normalizer\ConstraintViolationListNormalizer::class),
            Instance::ensure(Serializer\Normalizer\ProblemNormalizer::class),
            Instance::ensure(Serializer\Normalizer\JsonSerializableNormalizer::class),
            Instance::ensure(Serializer\Normalizer\UidNormalizer::class),
        ],
        [
            Instance::ensure(Serializer\Encoder\JsonEncoder::class),
        ]
    ],
]);

// Validator
$container->set(ValidatorInterface::class, fn() => (new ValidatorBuilder())->getValidator());
$container->set(QueryTokenAuth::class, [
    'class' => QueryTokenAuth::class,
    '__construct()' => [
        $_ENV['ADMIN_TOKEN'],
    ]
]);

// Http CQS
$container->set(ArgumentMetadataFactoryInterface::class, ArgumentMetadataFactory::class);

$container->set(ArgumentResolverInterface::class, [
    'class' => ArgumentResolver::class,
    '__construct()' => [
        Instance::of(ArgumentMetadataFactoryInterface::class),
        [
            Instance::ensure(ArgumentResolver\ScalarValueResolver::class),
            Instance::ensure(ArgumentResolver\InputValueResolver::class),
        ]
    ],
]);

// Repository
$container->set(ImageRepositoryInterface::class, ImageRepository::class);

// Image services
$container->set(LoadRandomImageQuery::class, LoadRandomImageQuery::class);

$container->set(RandomImageInterface::class, PicsumImageService::class);

$container->set(PicsumIntegrator::class, [
    'class' => PicsumIntegrator::class,
    '__construct()' => [
        $_ENV['PICSUM_URL'],
    ]
]);