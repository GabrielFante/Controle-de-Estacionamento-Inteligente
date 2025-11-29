<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\ParkingValidator;
use App\Domain\ParkingRepository;
use App\Domain\ParkingCalculator;
use App\Domain\Parking;

final class ParkingService
{
    public function __construct(
        private ParkingRepository $repository,
        private ParkingValidator $validator,
        private ParkingCalculator $calculator
    ) {}

    public function parkingReport(): array
    {
        return $this->repository->listAll();
    }

    public function registerVehicleEntry(array $input): array
    {
        $validation = $this->validator->validateEntry($input);

        if (!$validation['ok']) {
            return $validation;
        }

        $plate       = strtolower(trim($input['plate']));
        $vehicleType = strtoupper(trim($input['vehicleType']));
        $entryTime   = new \DateTimeImmutable();

        $parking = new Parking(
            $plate,
            $vehicleType,
            $entryTime
        );

        $this->repository->register($parking);

        return ['ok' => true];
    }

    public function doExitVehicle(string $plate): array
    {
        $validation = $this->validator->validateExit(['plate' => $plate]);

        if (!$validation['ok']) {
            return $validation;
        }

        try {
            $parking = $this->repository->findByPlate($plate);
            $calc = $this->calculator->calculate($parking);

            $this->repository->updateExitInfo(
                $plate,
                $calc['exitTime'],
                $calc['price'],
                $calc['hours']
            );

            return ['ok' => true, 'hours'=>$calc['hours'], 'price'=>$calc['price']];
        } catch (\Throwable $e) {
            return ['ok'=>false, 'errors'=>[$e->getMessage()]];
        }
    }
}