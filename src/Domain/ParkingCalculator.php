<?php
declare(strict_types=1);


namespace App\Domain;

use App\Domain\VehicleHourPrice;

final class ParkingCalculator
{
    public function calculateParking(\DateTimeImmutable $entryTime, ?\DateTimeImmutable $exitTime,string $vehicleType): float
    {
        if ($exitTime === null) {
            $exitTime = new \DateTimeImmutable();
        }

        $time = $entryTime->diff($exitTime) * $vehicleType->getHourPrice();
        return $time;
    }
}