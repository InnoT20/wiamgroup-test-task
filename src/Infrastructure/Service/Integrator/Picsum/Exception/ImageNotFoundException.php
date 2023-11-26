<?php
declare(strict_types=1);

namespace App\Infrastructure\Service\Integrator\Picsum\Exception;

use yii\web\NotFoundHttpException;

class ImageNotFoundException extends NotFoundHttpException
{

}