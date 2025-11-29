<?php
declare(strict_types=1);

namespace App\Domain\VehicleHourPrice;

require_once __DIR__ . 'IPrice.php';

class TruckPrice implements IPrice
{
    public function price(): int
    {
        return match($this) {
            self::TRUCK => 5,
        };
    }
}