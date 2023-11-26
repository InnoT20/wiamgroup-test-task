<?php
declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Infrastructure\Http\CQS\Resolver\YiiActionExecutor;
use yii\web\Response;

interface ResponseInterface
{
    public function __invoke(YiiActionExecutor $executor): Response;
}