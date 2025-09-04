<?php
// config/config.php

$config = [
    'app_name' => $_ENV['APP_NAME'] ?? 'Drip',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'user' => $_ENV['DB_USER'] ?? 'root',
        'pass' => $_ENV['DB_PASS'] ?? '',
        'name' => $_ENV['DB_NAME'] ?? 'drip',
    ]
];
