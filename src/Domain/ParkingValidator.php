<?php
declare(strict_types=1);

namespace App\Domain;

final class ParkingValidator
{
    public function validateEntry(array $input): array
    {
        $validPlateRegex = '/^[a-z0-9-]{5,7}$/';

        $errors = [];

        $plate = strtolower(trim((string)($input['plate'] ?? '')));

        if ($plate === '') {
            $errors[] = 'Placa inválida.';
        }

        if (!preg_match($validPlateRegex, $plate)) {
            $errors[] = 'Placa deve conter entre 5 e 7 caracteres e apenas letras minúsculas, números ou hífen.';
        }

        return [
            'ok' => empty($errors),
            'errors' => $errors
        ];
    }

    public function validateExit(array $input): array
    {
        $errors = [];

        $plate = strtolower(trim((string)($input['plate'] ?? '')));

        if ($plate === '') {
            $errors[] = 'Placa inválida.';
            return ['ok' => false, 'errors' => $errors];
        }

        return ['ok' => true];
    }
}