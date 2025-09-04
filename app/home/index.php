<?php
$title = humanize('home');
$homeActive = true;

// Content
ob_start();
?>
    <h1 class="h3 mb-4 text-gray-800">Welcome to <?= $_ENV['APP_NAME'] ?? 'Drip' ?></h1>
    <p>
        <strong><?= $_ENV['APP_NAME'] ?? 'Drip' ?></strong> is a lightweight and fast PHP & Go hybrid micro-framework 
        designed to help you build web applications with <em>speed</em> and <em>simplicity</em>.
    </p>
    <p>
        Unlike traditional MVC frameworks, <?= $_ENV['APP_NAME'] ?? 'Drip' ?> uses a <em>feature-based structure</em>. 
        Each resource (such as <code>user</code>, <code>auth</code>, or <code>home</code>) is fully isolated inside 
        its own folder, making it easy to copy, rename, and extend without touching the rest of the codebase.
    </p>
    <h5>Main Features:</h5>
    <ul>
        <li>📦 Simple and clean folder structure</li>
        <li>⚡ Fast performance, minimal overhead</li>
        <li>🛠 Built-in migration and seeding support</li>
        <li>🎯 Feature-based (resource-driven) development</li>
        <li>🚀 Mix of PHP (for views & templates) and Go (for APIs & heavy logic)</li>
    </ul>
    <p>
        Get started by exploring the <code>app/</code> folder, creating your first resource, 
        or editing this welcome page in <code>app/home/index.php</code>.
    </p>
    <p><em>Happy coding with <?= $_ENV['APP_NAME'] ?? 'Drip' ?>!</em></p>
<?php
$content = ob_get_clean();

// Master
require __DIR__ . '/../../template/master.php';
