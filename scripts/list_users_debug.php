<?php
$dbPath = __DIR__ . '/../database/database.sqlite';
try {
    if (!file_exists($dbPath)) {
        echo "Database file not found: $dbPath\n";
        exit(1);
    }

    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, name, email, is_admin FROM users");
    if ($stmt === false) {
        echo "Query failed, statement is false.\n";
        exit(1);
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!count($rows)) {
        echo "No users found.\n";
        exit;
    }

    foreach ($rows as $r) {
        echo sprintf("id=%s name=%s email=%s is_admin=%s\n", $r['id'] ?? 'NULL', $r['name'] ?? 'NULL', $r['email'] ?? 'NULL', array_key_exists('is_admin', $r) ? $r['is_admin'] : 'NULL');
    }
} catch (Throwable $e) {
    echo 'ERROR: ' . get_class($e) . ' - ' . $e->getMessage() . PHP_EOL;
    exit(1);
}

