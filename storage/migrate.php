<?php
declare(strict_types=1);

$dir = __DIR__;
$dbPath = $dir . '/database.sqlite';

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS parking (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    plate TEXT NOT NULL,
    vehicle_type TEXT NOT NULL CHECK (vehicle_type IN ('CAR', 'MOTORCYCLE', 'TRUCK')),
    entry_time TEXT NOT NULL,
    exit_time TEXT,
    price REAL CHECK(price >= 0)
);
SQL;

$pdo->exec($sql);

echo "OK\n";