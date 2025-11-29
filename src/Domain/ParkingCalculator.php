<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\VehicleHourPrice\CarPrice;
use App\Domain\VehicleHourPrice\TruckPrice;
use App\Domain\VehicleHourPrice\MotorcyclePrice;

final class ParkingCalculator
{
    public function calculateParking(
        \DateTimeImmutable $entryTime,
        ?\DateTimeImmutable $exitTime,
        IPrice $price
        ): float {
            if ($exitTime === null) {
                $exitTime = new \DateTimeImmutable();
            }

        $diff = $entryTime->diff($exitTime);
        $hours = (float) $diff->h + ($diff->days * 24);

        return $hours * $price->price();
    }

}