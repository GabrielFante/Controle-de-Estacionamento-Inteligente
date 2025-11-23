<?php
declare(strict_types=1);

use App\Contracts\ParkingValidator;

final class SimpleParkingValidator implements ParkingValidator
{
    public function validateEntry(string $plate, VehicleType $vehicle): bool
    {
        $platePattern = '/^[A-Z0-9]{1,7}$/';

        $errors = [];

        if (!preg_match($platePattern, $plate)) {
            $errors[] = 'Invalid license plate format.';
        }

        if (strlen($plate) > 7 || strlen($plate) < 7) {
            $errors[] = 'License plate needs length of 7 characters.';
        }

        if (!in_array($vehicle, VehicleType::cases())) {
            $errors[] = 'Unsupported vehicle type.';
        }

        if ($errors) {
            return ['ok' => false, 'errors' => $errors];
        }

        return ['ok' => false, 'errors' => [], 'data' => [
            'plate' => $plate,
            'vehicle' => $vehicle
        ]];
    }
}