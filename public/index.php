<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Enums\VehicleTypes;
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
            background-color: #2d2d2d;
        }

        #container {
            width: fit-content;
            margin: 20px auto 0 auto;
            text-align: left; 
        }

        #title{
            display: flex;
            justify-content: center;
            color: #ffff;
            text-shadow: 2px 2px 2px rgba(76, 0, 255, 1);
            font-size: 50px;
            font-weight: bold;
            
        }

        label{
            display: block;
            margin: .5rem 0;
        }

        input{
            margin: .5rem 0;
        }

        .btns{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        #btnCadastro{
          cursor: pointer;
          background-Color: rgba(14, 58, 1, 1);
          border: 2px solid rgba(42, 255, 0, 1);
          color: rgba(111, 255, 106, 1);
          border-radius: 10px;
          padding: 7px 7px;
          margin: 5px;
          font-size: 16px;  
          font-weight: bold;
        }

        #btnSaida{
          cursor: pointer;
          background-Color: rgba(59, 1, 1, 1);
          border: 2px solid rgba(255, 0, 0, 1);
          color: rgba(255, 90, 90, 1);
          border-radius: 10px;
          padding: 7px 7px;
          margin: 5px;
          font-size: 16px;  
          font-weight: bold;
        }

        #btnRelatorio{
          cursor: pointer;
          background-Color: rgba(3, 45, 68, 1);
          border: 2px solid rgba(0, 106, 255, 1);
          color: rgba(104, 235, 249, 1);
          border-radius: 10px;
          padding: 7px 7px;
          margin: 5px;
          font-size: 16px;
          font-weight: bold;  
        }

        a{
          text-decoration: none;  
          color: currentcolor;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1 id="title">Controle de Estacionamento Inteligente</h1>
        <div class="btns">
            <button id="btnCadastro">
                <a href="register.php">Cadastrar seu veiculo</a>
            </button>
            <button id="btnSaida">
                <a href="exit.php">Registrar saida</a>
            </button>
            <button id="btnRelatorio">
                <a href="report.php">Relátorio</a>
            </button>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>
</html>