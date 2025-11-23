<?php
declare(strict_types=1);

namespace App\Application;

use App\Contracts\ParkingValidator;
use App\Contracts\ParkingRepository;
use App\Enums\VehicleType;

final class ParkingService
{
    public function __construct(
        private ParkingRepository $repository,
        private ParkingValidator $validator
    ){ }

    /**
     * @return array<string, array{plate: string, vehicle: VehicleType, calculatedTime: $timeParked}>
     */
    public function parkingReport(): array
    {
        return $this->repository->getAllEntries();
    }

    public function calculateParking(string $plate): void
    {
        
    }

    /**
     * @param VehicleType::CAR|VehicleType::MOTORCYCLE|VehicleType::TRUCK $vehicle
     */
    public function registerVehicleEntry(array $input): void
    {
        $result = $this->validator->validateEntry($input);

        $entryData = new ParkingEntryData($input);
        $this->repository->saveEntry($entryData);
    }

    /**
     * @param string $plate
     */
    public function doExitVehicle(string $plate): void
    {

    }
}