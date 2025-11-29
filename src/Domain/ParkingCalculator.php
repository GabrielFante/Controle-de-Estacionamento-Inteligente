<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\VehicleHourPrice\CarPrice;
use App\Domain\VehicleHourPrice\TruckPrice;
use App\Domain\VehicleHourPrice\MotorcyclePrice;
use DateTimeImmutable;

final class ParkingCalculator
{
    public function calculate(Parking $parking): array
    {
        $now  = new DateTimeImmutable();
        $diff = $parking->getEntryTime()->diff($now);

        $hours = ($diff->days * 24) + $diff->h;
        if ($diff->i > 0 || $diff->s > 0) {
            $hours++;
        }
        $hours = (float) $hours;

        $pricePerHour = match ($parking->getVehicleType()) {
            'CAR'        => (new CarPrice())->price(),
            'MOTORCYCLE' => (new MotorcyclePrice())->price(),
            'TRUCK'      => (new TruckPrice())->price()
        };

        $total = $hours * $pricePerHour;

        return [
            'exitTime' => $now,
            'hours' => $hours,
            'price' => $total,
        ];
    }
}