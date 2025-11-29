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
        $this->pdo = $pdo;
    }

    public function save(Parking $parking): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO parking (plate, vehicle_type, entry_time, exit_time) VALUES (:plate, :vehicle_type, :entry_time, :exit_time)'
        );
        $stmt->execute([
            ':plate' => $parking->getPlate(),
            ':vehicle_type' => $parking->getVehicleType(),
            ':entry_time' => $parking->getEntryTime()->format('Y-m-d H:i:s'),
            ':exit_time' => $parking->getExitTime() ? $parking->getExitTime()->format('Y-m-d H:i:s') : null,
        ]);
    }
}