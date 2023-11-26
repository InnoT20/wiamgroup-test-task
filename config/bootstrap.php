<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = Yii::$container;

Yii::setAlias('@app', __DIR__ . '/../src');
Yii::setAlias('@App', '@app');
Yii::setAlias('@views', '@app/../views');