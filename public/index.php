<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use App\Infra\SqliteParkingRepository;
use App\Application\ParkingService;
use App\Domain\ParkingValidator;
use App\Domain\ParkingCalculator;

$pdo = new PDO('sqlite:/opt/lampp/htdocs/Controle-de-Estacionamento-Inteligente/storage/database.sqlite');
$repository = new SqliteParkingRepository($pdo);

$validator  = new ParkingValidator();
$calculator = new ParkingCalculator();
$service    = new ParkingService($repository, $validator, $calculator);

$exitResult = null;
$errorMsg   = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate = strtolower(trim($_POST['plate'] ?? ''));
    $type  = strtoupper(trim($_POST['vehicleType'] ?? ''));

    if (isset($_POST['entry'])) {
        $result = $service->registerVehicleEntry([
            'plate'       => $plate,
            'vehicleType' => $type
        ]);

        if (!$result['ok']) {
            $errorMsg = $result['errors'][0] ?? 'Erro ao registrar entrada.';
        }
    }

    if (isset($_POST['exit'])) {
        $result = $service->doExitVehicle($plate);

        if (!$result['ok']) {
            $errorMsg = $result['errors'][0] ?? 'Erro ao registrar saída.';
        } else {
            $exitResult = [
                'plate' => $plate,
                'hours' => $result['hours'],
                'price' => $result['price'],
            ];
        }
    }
}

$report = $repository->listAll();
$totalVehicles = count($report);

$totalRevenueCar = 0;
$totalRevenueMotorcycle = 0;
$totalRevenueTruck = 0;

foreach ($report as $v) {
    if ($v->getPrice() !== null) {
        match ($v->getVehicleType()) {
            'CAR' => $totalRevenueCar += $v->getPrice(),
            'MOTORCYCLE' => $totalRevenueMotorcycle += $v->getPrice(),
            'TRUCK' => $totalRevenueTruck += $v->getPrice(),
        };
    }
}

$generalRevenue = $totalRevenueCar + $totalRevenueMotorcycle + $totalRevenueTruck;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Parking System</title>
    <style>
        body {
            background:#0a0a0a;
            font-family:Inter,sans-serif;
            color:white;
            display:flex;
            justify-content:center;
            padding-top:50px;
        }
        .box {
            width:340px;
            background:#1a1a1a;
            padding:18px;
            border-radius:10px;
            box-shadow:0px 0px 8px rgba(138,43,226,0.4);
        }
        .summary {
            background:#222;
            padding:10px;
            border-radius:6px;
            font-size:14px;
            margin-bottom:14px;
            text-align:center;
        }
        .summary div { margin-bottom:4px; }
        input, select, button {
            width:100%;
            padding:10px;
            border:none;
            border-radius:6px;
            margin-bottom:10px;
            font-size:15px;
        }
        input, select {
            background:#252525;
            color:#ccc;
        }
        button {
            cursor:pointer;
            font-weight:600;
        }
        .btn-entry { background:#6a0dad; color:white; }
        .btn-exit  { background:#8e44ad; color:white; }
        .list {
            max-height:150px;
            overflow:auto;
            background:#111;
            padding:10px;
            border-radius:6px;
            font-size:13px;
        }
        .item {
            padding:6px 0;
            border-bottom:1px solid #2d2d2d;
            text-align:center;
        }
        .item:last-child { border:none; }
        .error {
            background:#c70039;
            padding:8px;
            border-radius:6px;
            font-size:13px;
            text-align:center;
            margin-bottom:10px;
        }
        .alert {
            background:#6a0dad;
            padding:8px;
            border-radius:6px;
            font-size:14px;
            text-align:center;
            margin-bottom:10px;
        }
    </style>
</head>
<body>
<div class="box">

    <div class="summary">
        <div>Total veículos: <?= $totalVehicles ?></div>
        <div>Faturamento Moto: R$ <?= $totalRevenueMotorcycle ?></div>
        <div>Faturamento Carro: R$ <?= $totalRevenueCar ?></div>
        <div>Faturamento Caminhão: R$ <?= $totalRevenueTruck ?></div>
        <div><strong>Total Faturado: R$ <?= $generalRevenue ?></strong></div>
    </div>

    <?php if ($errorMsg): ?>
        <div class="error"><?= htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <?php if ($exitResult): ?>
        <div class="alert">
            <?= htmlspecialchars($exitResult['plate'], ENT_QUOTES, 'UTF-8') ?>
            — <?= $exitResult['hours'] ?>h — R$ <?= $exitResult['price'] ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input name="plate" placeholder="Placa do veículo" required>

        <select name="vehicleType">
            <option value="CAR">Carro</option>
            <option value="TRUCK">Caminhão</option>
            <option value="MOTORCYCLE">Moto</option>
        </select>

        <button class="btn-entry" name="entry">Registrar Entrada</button>
        <button class="btn-exit" name="exit">Registrar Saída</button>
    </form>

    <div class="list">
        <?php foreach ($report as $v): ?>
            <div class="item">
                <?= htmlspecialchars($v->getPlate(), ENT_QUOTES, 'UTF-8') ?>
                — <?= $v->getVehicleType() ?>
                <?php if ($v->getExitTime() === null): ?>
                    — ativo
                <?php else: ?>
                    — <?= $v->getHours() ?>h — R$ <?= $v->getPrice() ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
</body>
</html>