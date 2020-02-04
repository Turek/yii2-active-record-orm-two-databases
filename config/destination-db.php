<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . getenv('DESTINATION_DB_HOST') . ';port=' . getenv('DESTINATION_DB_PORT') . ';dbname=' . getenv('DESTINATION_DB_DATABASE'),
    'username' => getenv('DESTINATION_DB_USERNAME'),
    'password' => getenv('DESTINATION_DB_PASSWORD'),
    'charset' => 'utf8',
];
