<?php
declare(strict_types=1);

namespace App\Domain;

interface ParkingRepository
{
    public function listAll(): array;

    public function register(Parking $parking): void;

    public function update(Parking $parking): void;

    public function findByPlate(string $plate): Parking;

    public function delete(int $id): void;
}