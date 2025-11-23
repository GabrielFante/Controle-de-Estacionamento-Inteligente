<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Enums\VehicleType;

final class ParkingPricingService
{
    /**
     * @param array{entry_time:string, vehicle:VehicleType} $entry
     * @return array{ok:bool, price?:float, hours?:int, errors?:array<string>}
     */
    public function calculatePrice(array $entry): array
    {
        if (!isset($entry['entry_time'], $entry['vehicle'])) {
            return ['ok' => false, 'errors' => ['Dados incompletos para cálculo.']];
        }

        $entryTime = new \DateTimeImmutable($entry['entry_time']);
        $now = new \DateTimeImmutable();

        $diffSeconds = $now->getTimestamp() - $entryTime->getTimestamp();
        if ($diffSeconds < 0) {
            return ['ok' => false, 'errors' => ['Horário de entrada inválido.']];
        }

        $hours = max(1, (int) ceil($diffSeconds / 3600));
        $vehicle = $entry['vehicle'];
        $price = $hours * $vehicle->price();

        return ['ok' => true, 'price' => round($price, 2), 'hours' => $hours];
    }
}