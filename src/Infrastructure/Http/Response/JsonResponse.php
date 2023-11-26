<?php
declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Infrastructure\Http\CQS\Resolver\YiiActionExecutor;
use Yii;
use yii\web\Response;

final class JsonResponse implements ResponseInterface
{
    public function __construct(private readonly array $data)
    {
    }

    public function __invoke(YiiActionExecutor $executor): Response
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        Yii::$app->response->data = $this->data;

        return Yii::$app->response;
    }
}