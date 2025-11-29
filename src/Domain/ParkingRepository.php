<?php
declare(strict_types=1);

namespace App\Domain;

interface ParkingRepository
{
    public function listAll(): array;

    public function register(Parking $parking): void;

    public function updateExitInfo(string $plate, \DateTimeImmutable $exitTime, float $price, float $hours): void;

    public function findByPlate(string $plate): Parking;

    public function delete(int $id): void;
}