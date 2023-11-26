<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Infrastructure\Http\CQS\Resolver\YiiActionExecutor;
use Psr\Http\Message\StreamInterface;
use yii\web\Response;

final class ViewResponse implements ResponseInterface
{

    public function __construct(
        private readonly string $view,
        private readonly array $params = []
    ) {
    }

    public function __invoke(YiiActionExecutor $executor): Response
    {
        $content = $executor->controller->render($this->view, $this->params);

        \Yii::$app->response->data = $content;

        return \Yii::$app->response;
    }
}