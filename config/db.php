<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $_ENV['PG_HOST'],
        $_ENV['PG_PORT'] ?? 5432,
        $_ENV['PG_DATABASE']
    ),
    'username' => $_ENV['PG_USER'],
    'password' => $_ENV['PG_PASSWORD'],
    'charset' => 'utf8',
];
