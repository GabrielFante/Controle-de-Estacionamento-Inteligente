<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\VehicleRepository;

final class VehicleService
{
    public function __construct(
        private VehicleRepository $vehicleRepository

    ){
    }


    public function registerVehicle(array $vehicle): array
    {
        $result = $this->validate($vehicle);

        if (!is_array($result)) {
            return ['ok' => false, 'errors' => ['internal' => 'Validation return wrong format']];
        }

        if (!($result['ok'] ?? false)) {
        return ['ok' => false, 'errors' => ($result['errors'] ?? ['internal' => 'Erro de validação'])];
        }

        $data = $result['data'] ?? null;
        if (!is_array($data) || !isset($data['name'], $data['price'])) {
            return ['ok' => false, 'errors' => ['internal' => 'Dados validados ausentes']];
        }

        $id = $this->repository->save($data);

        return ['ok' => true, 'id' => $id];
    }
}