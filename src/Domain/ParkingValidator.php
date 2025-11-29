<?php
declare(strict_types=1);

namespace App\Domain;

final class ParkingValidator
{
    public function parkingValidate(array $input): array
    {

        $validPlateRegex = '/^[a-z0-9-]{5,7}$/';
        
        $errors = [];

        $plate = strtolower(trim((string)($input['plate'] ?? '')));
        
        if ($plate === '' || !preg_match($plateRegex, $plate)) {
            $errors = 'Placa inválida. Deve conter entre 5 e 7 caracteres e não deve ser vazia.';
        }

        if ($plate === preg_match($validPlateRegex, $plate)) {
            $errors = 'Placa inválida. Deve conter apenas letras minúsculas, números';
        }
    }
}