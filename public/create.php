<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\ParkingService;

$vehicle = $_POST['veiculo'] ?? '';
$plate   = $_POST['plate'] ?? '';
$price   = $_POST['preco'] ?? '';

if (!$vehicle || !$plate || !$price) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Preencha todos os campos antes de continuar.'
        }).then(() => {
            window.location.href = 'create.php';
        });
    </script>
    ";
    exit;
}

$priceNumber = (float) str_replace(['R$', ',', ' '], '', $price);

$service = new ParkingService();
$service->register($vehicle, $plate, $priceNumber);

echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Registrado com sucesso!',
        text: 'O veículo foi cadastrado no sistema.'
    }).then(() => {
        window.location.href = 'index.php';
    });
</script>
";
exit;