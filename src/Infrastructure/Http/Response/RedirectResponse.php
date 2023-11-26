<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Infrastructure\Http\CQS\Resolver\YiiActionExecutor;
use yii\web\Response;

final class RedirectResponse implements ResponseInterface
{
    public function __construct(
        private readonly array|string $url,
        private readonly int $statusCode = 302
    ) {
    }

    public function __invoke(YiiActionExecutor $executor): Response
    {
        return $executor->controller->redirect($this->url, $this->statusCode);
    }
}