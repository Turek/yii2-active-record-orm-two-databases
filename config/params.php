<?php

$env_dir = '..' . DIRECTORY_SEPARATOR;

if (class_exists('\Dotenv\Dotenv') && file_exists($env_dir . '.env'))
{
    $dotenv = new \Dotenv\Dotenv($env_dir);
    $dotenv->load();
}
else
{
    echo 'Please, run composer install and try again.';
    return;
}

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
];
