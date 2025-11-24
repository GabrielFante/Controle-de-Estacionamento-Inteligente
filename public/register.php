<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Enums\VehicleType;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css">
  <title>Controle de Estacionamento Inteligente</title>

   <style>
        body{
            font-family:system-ui,Segoe UI,Arial;
            margin:2rem
        }
        label{
            display:block;
            margin:.5rem 0;
        }
        input{
            margin:.5rem 0;
        }
        button{
          cursor: pointer;
          background-color: rgba(2, 68, 122, 1);
          color: rgba(0, 204, 255, 1);
          border: 2px solid rgba(71, 130, 238, 1);
          border-radius: 10px;
        }
    </style>

</head>
<body>

  <h1>Controle de Estacionamento Inteligente</h1>
  <form action="create.php" method="POST">
    <select name="veiculo" id="veiculo" required>
      <option value="">Escolha um veículo para cadastro</option>
      <option value="CAR" data-price="5">Carro</option>
      <option value="MOTORCYCLE" data-price="3">Moto</option>
      <option value="TRUCK" data-price="10">Caminhão</option>
    </select>
    <label>Placa:
      <input name="plate" placeholder="Insira a placa" required>
    </label>
    <label>Preço:
      <input id="preco" name="preco" readonly>
    </label>
    <button type="submit">Cadastrar</button>
  </form>

<script>
  document.getElementById('veiculo').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const price = selected.getAttribute('data-price');

    document.getElementById('preco').value = price 
      ? `R$ ${price},00`
      : '';
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>

</body>
</html>
