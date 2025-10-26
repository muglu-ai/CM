<?php
// Simple script to inspect the SQLite DB for the event_sessions columns and migrations table
$dbFile = __DIR__ . '/../database/database.sqlite';
if (!file_exists($dbFile)) {
    echo "Database file not found at: $dbFile\n";
    exit(1);
}

try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "PRAGMA table_info('event_sessions'):\n";
    $stmt = $pdo->query("PRAGMA table_info('event_sessions')");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$cols) {
        echo "No such table 'event_sessions' or it has no columns.\n";
    } else {
        foreach ($cols as $col) {
            echo "- {$col['name']} ({$col['type']}) nullable:" . ($col['notnull'] ? 'no' : 'yes') . " default:" . ($col['dflt_value'] ?? 'NULL') . "\n";
        }
    }

    echo "\nMigrations table (latest 20):\n";
    $stmt = $pdo->query("SELECT id, migration, batch FROM migrations ORDER BY id DESC LIMIT 20");
    $migs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$migs) {
        echo "No migrations table or no rows found.\n";
    } else {
        foreach ($migs as $m) {
            echo "- [{$m['batch']}] {$m['migration']}\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

