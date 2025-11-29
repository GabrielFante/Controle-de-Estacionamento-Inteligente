<?php
declare(strict_types=1);

namespace App\Domain\VehicleHourPrice;

interface IPrice
{
    public function price(): int;
}