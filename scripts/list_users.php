<?php
$dbPath = __DIR__ . '/../database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "Database file not found: $dbPath\n";
    exit(1);
}
$pdo = new PDO('sqlite:' . $dbPath);
$stmt = $pdo->query("SELECT id, name, email, is_admin FROM users");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!count($rows)) {
    echo "No users found.\n";
    exit;
}
foreach ($rows as $r) {
    echo sprintf("id=%d name=%s email=%s is_admin=%s\n", $r['id'], $r['name'], $r['email'], isset($r['is_admin']) ? $r['is_admin'] : 'NULL');
}

