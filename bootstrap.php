<?php
// bootstrap.php

// 1. Load .env file (key=value format)
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // skip comment lines
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
        putenv(trim($key) . '=' . trim($value));
    }
}

// 2. Load global config
require_once __DIR__ . '/config/config.php';

// 3. Simple global middleware
function checkAuth() {
    // Example: check user session
    if (!isset($_SESSION)) {
        session_start();
    }
    if (empty($_SESSION['user_id'])) {
        // not logged in
        header("Location: index.php?r=auth/login");
        exit;
    }
}

function checkRole($role) {
    // Example: check user role, later can be fetched from DB
    $userRole = $_SESSION['role'] ?? 'guest';
    if ($userRole !== $role) {
        http_response_code(403);
        echo "403 Forbidden - Role required: $role";
        exit;
    }
}

// HELPER
if (!function_exists('humanize')) {
    function humanize(string $text): string
    {
        // Replace underscores and dashes with spaces
        $text = str_replace(['_', '-'], ' ', $text);

        // Capitalize the first letter of each word
        return ucwords($text);
    }
}
