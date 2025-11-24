<?php
declare(strict_types=1);

namespace App\Contracts;

interface ParkingRepository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAllEntries(): array;

    /**
     * @param array<string, mixed> $entry
     * @return int
     */
    public function saveEntry(array $entry): int;

    /**
     * @param string $plate
     * @return array<string, mixed>|null
     */
    public function getEntryByPlate(string $plate): ?array;

    /**
     * @param string $plate
     * @param \DateTimeImmutable $exitTime
     * @return void
     */
    public function updateExitTime(string $plate, \DateTimeImmutable $exitTime): void;
}