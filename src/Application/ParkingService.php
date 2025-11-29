<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\ParkingValidator;
use App\Domain\ParkingRepository;
use App\Domain\ParkingCalculator;

final class ParkingService
{
    public function __construct(
        private ParkingRepository $repository,
        private ParkingValidator $validator,
        private ParkingCalculator $calculator
    ) {}

    public function parkingReport(): array
    {
        return $this->repository->getAllEntries();
    }

    /**
     * @param array{plate:string, vehicle:string} $input
     * @return array{ok:bool, errors?:array<string>, id?:int}
     */
    public function registerVehicleEntry(array $input): array
    {
        $validation = $this->validator->validateEntry($input);

        if (!$validation['ok']) {
            return $validation;
        }
        
        $plate = strtolower(trim((string)$input['plate']));
        $vehicleType = strtolower(trim((string)$input['vehicleType']));
        $entryTime = strtolower(trim((string)$input['entryTime']));

        $parking = new Parking(plate, vehicleType, entryTime);
        $register = $this->$repository->register($parking);

        return ['ok' => true, 'id' => $register->id()];
    }

    /**
     * @return array{ok:bool, price?:float, hours?:int, errors?:array<string>}
     */
    public function doExitVehicle(string $plate): array
    {
        $validation = $this->validator->validateExit($plate);

        if (!$validation['ok']) {
            return $validation;
        }

        $entry = $this->repository->findByPlate($plate);

        $calculate = $this->pricing->calculatePrice($entry);

        if (!$calculate['ok']) {
            return $calculate;
        }

        $this->repository->updateExitInfo(
            $plate,
            new \DateTimeImmutable(),
            $calculate['hours']
        );

        return [
            'ok'    => true,
            'price' => $calculate['price'],
            'hours' => $calculate['hours'],
        ];
    }
}