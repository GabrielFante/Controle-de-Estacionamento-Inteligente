<?php
declare(strict_types=1);

namespace App\Infra;

use App\Domain\Parking;
use App\Domain\ParkingRepository;
use PDO;

final class SqliteParkingRepository implements ParkingRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function register(Parking $parking): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO parking (plate, vehicle_type, entry_time, exit_time) VALUES (:plate, :vehicle_type, :entry_time, :exit_time)'
        );
        $stmt->execute([
            ':id' => $parking->getId(),
            ':plate' => $parking->getPlate(),
            ':vehicle_type' => $parking->getVehicleType(),
            ':entry_time' => $parking->getEntryTime()->format('Y-m-d H:i:s'),
            ':exit_time' => $parking->getExitTime() ? $parking->getExitTime()->format('Y-m-d H:i:s') : null,
        ]);
    }

    public function listAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM parking');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $parkings = [];
        foreach ($rows as $row) {
            $parkings[] = new Parking(
                (int)$row['id'],
                $row['plate'],
                $row['vehicle_type'],
                new \DateTimeImmutable($row['entry_time']),
                $row['exit_time'] ? new \DateTimeImmutable($row['exit_time']) : null
            );
        }

        return $parkings;
    }

    public function updateExitInfo(string $plate, \DateTimeImmutable $exitTime, float $hours): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE parking SET exit_time = :exit_time, hours = :hours WHERE plate = :plate'
        );

        $stmt->execute([
            ':plate' => $plate,
            ':exit_time' => $exitTime->format('Y-m-d H:i:s'),
            ':hours' => $hours,
        ]);
    }

    public function findByPlate(string $plate): Parking
    {
        $stmt = $this->pdo->prepare('SELECT * FROM parking WHERE plate = :plate');
        $stmt->execute([':plate' => $plate]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new \RuntimeException("Parking entry with plate $plate not found.");
        }

        return new Parking(
            (int)$row['id'],
            $row['plate'],
            $row['vehicle_type'],
            new \DateTimeImmutable($row['entry_time']),
            $row['exit_time'] ? new \DateTimeImmutable($row['exit_time']) : null
        );
    }

    
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM parking WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}