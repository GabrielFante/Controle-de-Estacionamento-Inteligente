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
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('https://imgs.search.brave.com/mNTD7F8i3mpr0gcsL7FUjcDnoKywCELUWwIi_ZArHe0/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/dmV0b3Jlcy1wcmVt/aXVtL3ZldG9yLWRl/LXNpbmFsLWRlLW5l/b24tZGUtZXN0YWNp/b25hbWVudG8tbW9k/ZWxvLWRlLWRlc2ln/bi1kZS16b25hLWRl/LWVzdGFjaW9uYW1l/bnRvLWJhbm5lci1k/ZS1sdXotZGUtc2lu/YWwtZGUtbmVvbi1w/bGFjYS1kZS1uZW9u/LXRvZGFzLWFzLW5v/aXRlcy1pbnNjcmlj/YW8tZGUtbHV6LWRl/LXB1YmxpY2lkYWRl/LWJyaWxoYW50ZS1p/bHVzdHJhY2FvLXZl/dG9yaWFsXzU0OTg5/Ny0yMTE5LmpwZz9z/ZW10PWFpc19oeWJy/aWQ');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        #container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        #title{
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffff;
            text-shadow: 0px 0px 6px rgba(76, 0, 255, 1), 0px 0px 6px rgba(76, 0, 255, 1);
            font-size: 40px;
            font-weight: bold;
        }

        .card {
            border-radius: 8px;
            color: #ffffff;
            background-color: rgba(2, 68, 122, 1);
            padding: 25px;
            margin: 10px;
            width: 250px;          
        }

        label{
            display: block;
            margin: .5rem 0;
            text-shadow: 4px 2px 3px rgba(55, 0, 255, 1);
        }

        input{
            margin: .5rem 0;
            border-radius: 8px;
        
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
    <div id="container">
    <h1 id="title">Cadastre seu veículo</h1>
    <form class="card" action="create.php" method="POST">
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
        <input id="preco" name="price" readonly>
        </label>
        <button type="submit">Cadastrar</button>
    </form>
    </div>
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