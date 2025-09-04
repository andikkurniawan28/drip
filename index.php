<?php
// index.php

require __DIR__ . '/bootstrap.php';

$route = $_GET['r'] ?? 'home/index';

$file = __DIR__ . '/app/' . $route . '.php';

if (file_exists($file)) {
    require $file;
} else {
    http_response_code(404);
    echo "404 Not Found<br>";
    echo "Tried to load: " . htmlspecialchars($file);
}
