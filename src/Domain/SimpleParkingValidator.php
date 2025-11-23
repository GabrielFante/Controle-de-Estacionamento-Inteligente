<?php
declare(strict_types=1);

namespace App\Domain\Validators;

use App\Contracts\ParkingValidator;
use App\Contracts\ParkingRepository;
use App\Enums\VehicleType;

final class SimpleParkingValidator implements ParkingValidator
{
    public function __construct(
        private ParkingRepository $repository
    ) {}

    public function validateEntry(array $input): array
    {
        $plate   = strtoupper(trim($input['plate'] ?? ''));
        $vehicle = strtoupper(trim($input['vehicle'] ?? ''));

        $errors = [];

        if (!$this->isValidPlate($plate)) {
            $errors[] = "Formato da placa inválido.";
        }

        $vehicleEnum = VehicleType::tryFrom($vehicle);
        if (!$vehicleEnum) {
            $errors[] = "Tipo de veículo inválido.";
        }

        if ($this->repository->getEntryByPlate($plate)) {
            $errors[] = "Este veículo já está estacionado.";
        }

        if ($errors) {
            return ['ok' => false, 'errors' => $errors];
        }

        return [
            'ok'     => true,
            'plate'  => $plate,
            'vehicle'=> $vehicleEnum
        ];
    }

    public function validateExit(string $plate): array
    {
        $plate = strtoupper(trim($plate));
        $entry = $this->repository->getEntryByPlate($plate);

        if (!$entry) {
            return ['ok' => false, 'errors' => ["O veículo não está estacionado."]];
        }

        return $this->calculatePrice($entry);
    }

    public function calculatePrice(array $entry): array
    {
        if (!isset($entry['entry_time'], $entry['vehicle'])) {
            return ['ok' => false, 'errors' => ["Dados incompletos para cálculo."]];
        }

        $entryTime = new \DateTimeImmutable($entry['entry_time']);
        $exitTime  = new \DateTimeImmutable();

        $diffSeconds = $exitTime->getTimestamp() - $entryTime->getTimestamp();

        if ($diffSeconds < 0) {
            return ['ok' => false, 'errors' => ["Horário de entrada inválido."]];
        }

        $hours = max(1, (int) ceil($diffSeconds / 3600));

        $vehicle = $entry['vehicle'];
        $price = $hours * $vehicle->price();

        return [
            'ok'    => true,
            'price' => $price,
            'hours' => $hours
        ];
    }


    private function isValidPlate(string $plate): bool
    {
        return (bool) preg_match('/^[A-Z0-9]{7}$/', $plate);
    }
}