<?php
declare(strict_types=1);
require '../vendor/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Entrada</title>
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
        width: 320px;
        background: #171717;
        padding: 18px;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(138, 43, 226, 0.4);
    }
    label {
        font-size: 14px;
        display: block;
        margin-bottom: 6px;
    }
    input, select, button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        margin-bottom: 10px;
        font-size: 15px;
        background: #252525;
        color: #ccc;
    }
    button.submit {
        background: #6a0dad;
        color: white;
        font-weight: 600;
    }
    button.back {
        background: #111;
        color: #888;
        font-weight: 600;
    }
</style>
</head>
<body>
<div class="card">
<form method="POST" action="index.php">
    <label>Placa</label>
    <input name="plate" required>
    <label>Tipo</label>
    <select name="vehicleType">
        <option value="CAR">Carro</option>
        <option value="TRUCK">Caminhão</option>
        <option value="MOTORCYCLE">Moto</option>
    </select>
    <button class="submit submit" name="entry">Registrar</button>
</form>
<button class="back" onclick="location.href='index.php'">Voltar</button>
</div>
</body>
</html>