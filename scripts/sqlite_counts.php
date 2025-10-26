<?php
$dbPath = __DIR__ . '/../database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "Database file not found: $dbPath\n";
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$tables = ['events','event_sessions','speakers','session_speaker','users','tracks'];
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as c FROM $table");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
        echo "$table: $count\n";
    } catch (Throwable $e) {
        echo "$table: ERROR - " . $e->getMessage() . "\n";
    }
}

// Count sessions with track_id
try {
    $stmt = $pdo->query("SELECT COUNT(*) as c FROM event_sessions WHERE track_id IS NOT NULL");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
    echo "event_sessions_with_track: $count\n";
} catch (Throwable $e) {
    echo "event_sessions_with_track: ERROR - " . $e->getMessage() . "\n";
}
