<?php
declare(strict_types=1);

namespace App\Application;

use App\Contracts\ParkingValidator;
use App\Contracts\ParkingRepository;
use App\Domain\Services\ParkingPricingService;

final class ParkingService
{
    public function __construct(
        private ParkingRepository $repository,
        private ParkingValidator $validator,
        private ParkingPricingService $pricing
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
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

        $id = $this->repository->saveEntry([
            'plate' => $validation['plate'],
            'vehicle' => $validation['vehicle'],
            'entry_time' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'exit_time'  => null
        ]);

        return ['ok' => true, 'id' => $id];
    }

    /**
     * @return array{ok:bool, price?:float, hours?:int, errors?:array<string>}
     */
    public function calculateParking(string $plate): array
    {
        $entry = $this->repository->getEntryByPlate($plate);

        if (!$entry) {
            return ['ok' => false, 'errors' => ["Veículo não encontrado."]];
        }

        return $this->pricing->calculatePrice($entry);
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

        $entry = $validation['entry'];

        $calculate = $this->pricing->calculatePrice($entry);

        if (!$calculate['ok']) {
            return $calculate;
        }

        $this->repository->updateExitTime(
            $plate,
            new \DateTimeImmutable(),
            $calculate['price'],
            $calculate['hours']
        );

        return [
            'ok'    => true,
            'price' => $calculate['price'],
            'hours' => $calculate['hours'],
        ];
    }
}