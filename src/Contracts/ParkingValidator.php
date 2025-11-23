<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Enums\VehicleType;

interface ParkingValidator
{
    public function validateEntry(string $plate, VehicleType $vehicle): bool;
}