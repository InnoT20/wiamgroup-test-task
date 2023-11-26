<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Infrastructure\Http\CQS\Resolver\YiiActionExecutor;
use Psr\Http\Message\StreamInterface;
use yii\web\Response;

final class StreamFileResponse implements ResponseInterface
{
    /** @var resource */
    private $resource;

    /**
     * @param StreamInterface|resource $resource
     */
    public function __construct(
        mixed $resource,
        private readonly string $attachmentName,
        private readonly string $mimeType = 'application/octet-stream',
        private readonly bool $inline = true
    ) {
        if ($resource instanceof StreamInterface) {
            $this->resource = $resource->detach();
        } else {
            $this->resource = $resource;
        }
    }

    public function __invoke(YiiActionExecutor $executor): Response
    {
        return \Yii::$app->response->sendStreamAsFile(
            handle: $this->resource,
            attachmentName: $this->attachmentName,
            options: [
                'mimeType' => $this->mimeType,
                'inline' => $this->inline
            ]
        );
    }
}