<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Behaviour;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

final class QueryTokenAuth extends ActionFilter
{
    public function __construct(private readonly string $token, $config = [])
    {
        parent::__construct($config);
    }

    public function beforeAction($action): bool
    {
        $request = Yii::$app->getRequest();

        $token = $request->get('token');

        if ($token === $this->token) {
            return true;
        }

        throw new ForbiddenHttpException('Access denied');
    }
}