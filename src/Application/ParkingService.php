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
        
        return [];
    }

    /**
     * @param VehicleType::CAR|VehicleType::MOTORCYCLE|VehicleType::TRUCK $vehicle
     */
    public function registerVehicleEntry(string $plate, VehicleType $vehicle): void
    {
        $result = $this->validator->validateEntry($plate, $vehicle);

        $entryData = new ParkingEntryData($plate, $vehicle, new \DateTimeImmutable());
        $this->repository->saveEntry($entryData);
    }

    /**
     * @param string $plate
     */
    public function doExitVehicle(string $plate): void
    {

    }
}