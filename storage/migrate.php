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
  vehicle_type TEXT NOT NULL,
  entry_time DATETIME NOW,
  exit_time
);
SQL;

$pdo->exec($sql);

echo "OK: database.sqlite e tabela parking criados/atualizados.\n";