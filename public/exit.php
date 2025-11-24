<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\ParkingService;
?>

$service = new ParkingService(
    repository: new \App\Infrastructure\SQLiteParkingRepository(),
    validator: new \App\Domain\Validation\ParkingValidatorService(),
    pricing: new \App\Domain\Services\ParkingPricingService()
);

$plate = $_POST['plate'] ?? null;

$result = $service->doExitVehicle($plate);

if (!$result['ok']) {
    $errors = implode(', ', $result['errors'] ?? []);
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao registrar saída',
            text: '$errors'
        }).then(() => {
            window.location = 'index.php';
        });
    </script>";
    exit;
}

$horas = $result['hours'];
$preco = number_format($result['price'], 2, ',', '.');

echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Saída registrada!',
        html: 'Tempo total: <b>$horas</b> hora(s)<br>Valor a pagar: <b>R$ $preco</b>',
    }).then(() => {
        window.location = 'index.php';
    });
</script>";