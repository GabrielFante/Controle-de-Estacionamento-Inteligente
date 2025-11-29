<?php
declare(strict_types=1);
require '../vendor/autoload.php';

$pdo = new PDO('sqlite:/opt/lampp/htdocs/Controle-de-Estacionamento-Inteligente/storage/database.sqlite');
$stmt = $pdo->query('SELECT vehicle_type, COUNT(*) as total, SUM(price) as revenue FROM parking GROUP BY vehicle_type');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalRevenue = 0;
$totalCount = 0;
foreach ($rows as $r) {
    $totalRevenue += (float)($r['revenue'] ?? 0);
    $totalCount += (int)$r['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Relatório</title>
<style>
    body {
    background: #0a0a0a;
    font-family: Inter, sans-serif;
    color: white;
    display: flex;
    justify-content: center;
    padding-top: 50px;
    }
    .card {
        width: 360px;
        background: #171717;
        padding: 18px;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(138, 43, 226, 0.4);
    }
    h2 {
        font-size: 18px;
        margin-bottom: 14px;
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-bottom: 12px;
    }
    th, td {
        padding: 8px;
        border-bottom: 1px solid #2a2a2a;
        text-align: center;
    }
    th {
        background: #222;
    }
    .total {
        background: #222;
        padding: 10px;
        border-radius: 6px;
        font-size: 15px;
        text-align: center;
        font-weight: 600;
        margin-bottom: 10px;
    }
    button.back {
        width: 100%;
        padding: 10px;
        background: #6a0dad;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
    }
</style>
</head>
<body>

<div class="card">
    <h2>Relatório de estacionamento</h2>
    <div class="total">Total veículos: <?= $totalCount ?> | Faturamento: R$ <?= $totalRevenue ?></div>

    <table>
        <tr>
            <th>Tipo</th>
            <th>Quantidade</th>
            <th>Faturamento</th>
        </tr>
        <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= $r['vehicle_type'] ?></td>
            <td><?= $r['total'] ?></td>
            <td>R$ <?= $r['revenue'] ?? 0 ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <button class="back" onclick="location.href='index.php'">Voltar</button>
</div>

</body>
</html>