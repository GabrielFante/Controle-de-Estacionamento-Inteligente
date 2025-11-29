<?php
declare(strict_types=1);

namespace App\Domain\VehicleHourPrice;

final class TruckPrice implements IPrice
{
    public function price(): int
    {
        return 10;
    }
}