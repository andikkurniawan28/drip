<?php
// migrate.php

require __DIR__ . '/bootstrap.php';

// 1. Connect to database using PDO
try {
    $dsn = "{$_ENV['DB_DRIVER']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}";
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "✅ Connected to database successfully\n";
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "\n");
}

// 2. Define schema (drop + create tables)
$schema = [
    // Drop old tables
    "DROP TABLE IF EXISTS user",
    "DROP TABLE IF EXISTS role",

    // Create role table
    "CREATE TABLE role (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE,
        description VARCHAR(255)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    // Create user table
    "CREATE TABLE user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
];

// 3. Execute schema
foreach ($schema as $sql) {
    try {
        $pdo->exec($sql);
        echo "✅ Executed: $sql\n";
    } catch (PDOException $e) {
        echo "❌ Error executing [$sql]: " . $e->getMessage() . "\n";
    }
}

// 4. Seed initial data
try {
    // Seed role
    $pdo->exec("INSERT INTO role (name, description) VALUES 
        ('admin', 'Administrator role'),
        ('user', 'Regular user role')");
    echo "✅ Seeded role table\n";

    // Get admin role_id
    $roleId = $pdo->query("SELECT id FROM role WHERE name = 'admin' LIMIT 1")->fetchColumn();

    // Secure password hashing with bcrypt
    $hashedPassword = password_hash('password', PASSWORD_BCRYPT);

    // Seed admin user
    $stmt = $pdo->prepare("INSERT INTO user (name, email, password, role_id) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Admin User', 'admin@drip.local', $hashedPassword, $roleId]);
    echo "✅ Seeded admin user with bcrypt password\n";
} catch (PDOException $e) {
    echo "❌ Error seeding data: " . $e->getMessage() . "\n";
}

echo "🎉 Migration finished successfully!\n";
