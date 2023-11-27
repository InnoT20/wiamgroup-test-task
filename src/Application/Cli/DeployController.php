<?php

declare(strict_types=1);

namespace App\Application\Cli;

use yii\console\Controller;
use yii\console\ExitCode;

class DeployController extends Controller
{
    /**
     * Check connection to postgresql
     *
     * @return int
     */
    public function actionCheckConnection(): int
    {
        try {
            \Yii::$app->db->open();
        } catch (\Throwable) {
            $this->stdout('No connection');
        }

        return ExitCode::OK;
    }
}
