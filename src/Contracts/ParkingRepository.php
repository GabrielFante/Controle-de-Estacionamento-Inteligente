<?php
declare(strict_types=1);

namespace App\Contracts;

interface ParkingRepository
{
    public function saveEntry(ParkingEntryData $entryData): void;

    public function findEntryByPlate(string $plate): ?ParkingEntryData;

    public function saveExit(string $plate, \DateTimeImmutable $exitTime): void;
}