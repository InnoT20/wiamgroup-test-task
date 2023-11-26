<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Infrastructure\Http\CQS\CqsInterface;
use App\Infrastructure\Http\CQS\QueryInterface;
use App\Infrastructure\Http\CQS\Resolver\YiiActionExecutor;
use Yii;
use yii\web\Controller as BaseController;
use yii\web\Response;

abstract class Controller extends BaseController
{
    public function beforeAction($action): bool
    {
        if ($this instanceof JsonControllerInterface) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @param string $id
     * @param class-string<QueryInterface> $class
     * @return mixed
     */
    public function execute(string $id, string $class): mixed
    {
        if (class_exists($class) === false) {
            throw new \RuntimeException(sprintf('Class %s not found', $class));
        }

        \Yii::$container->set(CqsInterface::class, $class);

        return Yii::createObject(YiiActionExecutor::class, [$id, $this]);
    }
}