<?php
declare(strict_types=1);

namespace App\Contracts;

interface ParkingValidator
{
    /**
     * @param VehicleType::CAR|VehicleType::MOTORCYCLE|VehicleType::TRUCK $vehicle
     */
    public function validateEntry(string $plate, VehicleType $vehicle): bool;
}