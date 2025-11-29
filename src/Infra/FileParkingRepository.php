<?php
declare(strict_types=1);

namespace App\Infra;

use App\Contracts\ParkingRepository;
use SQLite3;
use DateTimeImmutable;

final class FileParkingRepository implements ParkingRepository
{
    private SQLite3 $connection;

    public function __construct(string $filePath)
    {
        if (!file_exists($filePath)) {
            $dir = dirname($filePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $this->connection = new SQLite3($filePath);
            $this->connection->exec("CREATE TABLE IF NOT EXISTS parking_entries (id INTEGER PRIMARY KEY, data TEXT NOT NULL)");
        } else {
            $this->connection = new SQLite3($filePath);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAllEntries(): array
    {
        $result = $this->connection->query("SELECT id, data FROM parking_entries");
        $entries = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $decoded = json_decode($row['data'], true);
            if ($decoded) {
                $entries[] = $decoded;
            }
        }
        return $entries;
    }

    /**
     * @param array<string, mixed> $entry
     * @return int
     */
    public function saveEntry(array $entry): int
    {
        $json = json_encode($entry, JSON_UNESCAPED_UNICODE);
        $declared = $this->connection->prepare("INSERT INTO parking_entries (data) VALUES (:data)");
        $declared->bindValue(':data', $json, SQLITE3_TEXT);
        $declared->execute();
        return $this->connection->lastInsertRowID();
    }

    /**
     * @param string $plate
     * @return array<string, mixed>|null
     */
    public function getEntryByPlate(string $plate): ?array
    {
        $entries = $this->getAllEntries();
        foreach ($entries as $entry) {
            if (strcasecmp($entry['plate'], $plate) === 0) {
                return $entry;
            }
        }
        return null;
    }

    /**
     * @param string $plate
     * @param DateTimeImmutable $exitTime
     * @return void
     */
    public function updateExitTime(string $plate, DateTimeImmutable $exitTime, float $price, int $hours): void
    {
        $json = $this->prepareUpdatedEntry(
        $found['entry'],
        $exitTime,
        $price,
        $hours
    );

    $this->updateEntryInDatabase($found['id'], $json);
}

    private function findEntry(string $plate): ?array
    {
        $entries = $this->getAllEntries();
        foreach ($entries as $index => $entry) {
            if (strcasecmp($entry['plate'], $plate) === 0) {
                return ['id' => $index + 1, 'entry' => $entry];
            }
        }
        return null;
    }

    private function prepareUpdatedEntry( array $entry, DateTimeImmutable $exitTime, float $price, int $hours): string 
    {
        $entry['exit_time'] = $exitTime->format('Y-m-d H:i:s');
        $entry['price']     = $price;
        $entry['hours']     = $hours;

        return json_encode($entry, JSON_UNESCAPED_UNICODE);
    }

    private function updateEntryInDatabase(int $id, string $json): void
    {
        $declared = $this->connection->prepare("UPDATE parking_entries SET data = :data WHERE id = :id");
        $declared->bindValue(':data', $json, SQLITE3_TEXT);
        $declared->bindValue(':id', $id, SQLITE3_INTEGER);
        $declared->execute();
    }
}