<?php
$dbPath = __DIR__ . '/../database/database.sqlite';
try {
    if (!file_exists($dbPath)) {
        echo "Database file not found: $dbPath\n";
        exit(1);
    }

    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "PRAGMA table_info(users):\n";
    $stmt = $pdo->query("PRAGMA table_info(users)");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $c) {
        echo sprintf("cid=%s name=%s type=%s notnull=%s dflt_value=%s pk=%s\n", $c['cid'], $c['name'], $c['type'], $c['notnull'], $c['dflt_value'], $c['pk']);
    }

    echo "\nSample rows (up to 5):\n";
    $stmt = $pdo->query("SELECT * FROM users LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!count($rows)) {
        echo "No rows in users table.\n";
        exit;
    }
    foreach ($rows as $r) {
        echo var_export($r, true) . "\n";
    }
} catch (Throwable $e) {
    echo 'ERROR: ' . get_class($e) . ' - ' . $e->getMessage() . PHP_EOL;
    exit(1);
}

