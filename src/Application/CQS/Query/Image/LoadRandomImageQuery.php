<?php

declare(strict_types=1);

namespace App\Application\CQS\Query\Image;

use App\Infrastructure\Http\CQS\QueryInterface;
use App\Infrastructure\Http\Response\ResponseInterface;
use App\Infrastructure\Http\Response\StreamFileResponse;
use App\Infrastructure\Service\RandomImage\Dimension;
use App\Infrastructure\Service\RandomImage\RandomImageInterface;

final class LoadRandomImageQuery implements QueryInterface
{
    public function __construct(private readonly RandomImageInterface $randomImage)
    {
    }

    public function __invoke(): ResponseInterface
    {
        /** @var Dimension $dimension */
        $dimension = \Yii::$app->params['dimension'];

        $stream = $this->randomImage->load($dimension);

        \Yii::$app->response->getHeaders()->set('X-Image-Id', $stream->id);

        return new StreamFileResponse($stream->stream, 'image.jpeg', 'image/jpeg');
    }
}