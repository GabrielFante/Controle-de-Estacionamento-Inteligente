<?php

declare(strict_types=1);

namespace App\Infra;

use App\Contracts\ParkingRepository;

final class FileParkingRepository implements ParkingRepository
{
    public function __construct(private string $filePath)
    {
        $this->filePath = $filePath;

        $dir = dirname($this->filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

    public function saveEntry(string $plate, VehicleType $vehicle): void
    {
        $id = $this->nextId();
        $entryArray = [
            'id' => $id,
            'plate' => $plate,
            'vehicle' => $vehicle,
            'entryTime' => $entryData = new \DateTimeImmutable()
        ];
    }

    public function getEntryByPlate(string $plate): ?object
    {
        // Implementation to retrieve parking entry data by plate from a file
        return null;
    }

    public function updateExitData(string $plate, \DateTimeImmutable $exitTime): void
    {
        // Implementation to update parking exit data in a file
    }

    public function getAllEntries(): array
    {
        $vehicles = [];
        $filePathVehicle = fopen($this->filePath, 'rb');
        if ($filePathVehicle === false) {
            return $items;
        }
        while (($line = fgets($filePathVehicle)) !== false) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $row = json_decode($line, true);
            if (is_array($row) && isset($row['id'], $row['name'], $row['price'])) {
                $items[] = [
                    'id' => (int)$row['id'],
                    'name' => (string)$row['name'],
                    'price' => (float)$row['price'],
                ];
            }
        }
        fclose($filePathVehicle);
        return $items;
    }
}