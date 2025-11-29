<?php
declare(strict_types=1);

namespace App\Contracts;

use App\Enums\VehicleType;

interface ParkingValidator
{
    /**
     * @param array{plate:string, vehicle:string} $input
     * @return array{ok:bool, errors?:array<string>, plate?:string, vehicle?:VehicleTypes, entry?:array}
     */
    public function validateEntry(array $input): array;

    /**
     * @return array{ok:bool, errors?:array<string>, entry?:array}
     */
    public function validateExit(string $plate): array;
}