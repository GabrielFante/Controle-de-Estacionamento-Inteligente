<?php
declare(strict_types=1);

namespace App\Enums;

enum VehicleType: string
{
    case CAR = 'CAR';
    case MOTORCYCLE = 'MOTORCYCLE';
    case TRUCK = 'TRUCK';

    public function price(): int
    {
        return match($this) {
            self::CAR => 5,
            self::MOTORCYCLE => 3,
            self::TRUCK => 10,
        };
    }
}