<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . getenv('SOURCE_DB_HOST') . ';port=' . getenv('SOURCE_DB_PORT') . ';dbname=' . getenv('SOURCE_DB_DATABASE'),
    'username' => getenv('SOURCE_DB_USERNAME'),
    'password' => getenv('SOURCE_DB_PASSWORD'),
    'charset' => 'utf8',
];
