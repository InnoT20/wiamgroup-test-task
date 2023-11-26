<?php

declare(strict_types=1);

namespace App\Application\Cli;

use yii\console\Controller;

class DeployController extends Controller
{
    /**
     * Check connection to postgresql
     * @return int
     */
    public function actionCheckConnection(): int
    {
        try {
            \Yii::$app->db->open();
        } catch (\Exception $e) {
            return 1;
        }

        return 0;
    }
}