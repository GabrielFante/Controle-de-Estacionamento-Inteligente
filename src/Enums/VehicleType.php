<?php
declare(strict_types=1);

namespace App\Models;

enum VehicleType: string
{
    case CAR = 'car';
    case MOTORCYCLE = 'motorcycle';
    case TRUCK = 'truck';
}