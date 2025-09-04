<?php
// config/config.php

// Base configuration
$config = [
    'app_name' => $_ENV['APP_NAME'] ?? 'Drip',
    'env'      => $_ENV['APP_ENV'] ?? 'production',
    'db'       => [
        'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
        'host'   => $_ENV['DB_HOST'] ?? 'localhost',
        'port'   => $_ENV['DB_PORT'] ?? '3306',
        'user'   => $_ENV['DB_USER'] ?? 'root',
        'pass'   => $_ENV['DB_PASS'] ?? '',
        'name'   => $_ENV['DB_NAME'] ?? 'drip',
    ],
];

// Create PDO connection (global $pdo)
try {
    $dsn = sprintf(
        "%s:host=%s;port=%s;dbname=%s;charset=utf8mb4",
        $config['db']['driver'],
        $config['db']['host'],
        $config['db']['port'],
        $config['db']['name']
    );

    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
