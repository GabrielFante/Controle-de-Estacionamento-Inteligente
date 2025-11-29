<?php
declare(strict_types=1);

namespace App\Infra;

use App\Domain\Parking;
use App\Domain\ParkingRepository;
use PDO;
use DateTimeImmutable;

final class SqliteParkingRepository implements ParkingRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function register(Parking $parking): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO parking (plate, vehicle_type, entry_time) VALUES (:plate, :vehicle_type, :entry_time)'
        );
        $stmt->execute([
            ':plate' => $parking->getPlate(),
            ':vehicle_type' => $parking->getVehicleType(),
            ':entry_time' => $parking->getEntryTime()->format('Y-m-d H:i:s')
        ]);
    }

    public function listAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM parking');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $list = [];
        foreach ($rows as $row) {
            $list[] = new Parking(
                $row['plate'],
                $row['vehicle_type'],
                new DateTimeImmutable($row['entry_time']),
                isset($row['exit_time']) && $row['exit_time'] ? new DateTimeImmutable($row['exit_time']) : null,
                isset($row['hours']) ? (float)$row['hours'] : null,
                isset($row['price']) ? (float)$row['price'] : null,
                isset($row['id']) ? (int)$row['id'] : null
            );
        }

        return $list;
    }

    public function findByPlate(string $plate): Parking
    {
        $stmt = $this->pdo->prepare('SELECT * FROM parking WHERE plate = :plate');
        $stmt->execute([':plate' => $plate]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new \RuntimeException("Vehicle $plate not found.");
        }

        return new Parking(
            $row['plate'],
            $row['vehicle_type'],
            new DateTimeImmutable($row['entry_time']),
            isset($row['exit_time']) && $row['exit_time'] ? new DateTimeImmutable($row['exit_time']) : null,
            isset($row['hours']) ? (float)$row['hours'] : null,
            isset($row['price']) ? (float)$row['price'] : null,
            isset($row['id']) ? (int)$row['id'] : null
        );
    }

    public function updateExitInfo(string $plate, DateTimeImmutable $exitTime, float $price, float $hours): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE parking SET exit_time = :exit_time, price = :price, hours = :hours WHERE plate = :plate'
        );
        $stmt->execute([
            ':plate' => $plate,
            ':exit_time' => $exitTime->format('Y-m-d H:i:s'),
            ':price' => $price,
            ':hours' => $hours
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM parking WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}