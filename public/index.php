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
            background-image: url('https://imgs.search.brave.com/mNTD7F8i3mpr0gcsL7FUjcDnoKywCELUWwIi_ZArHe0/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/dmV0b3Jlcy1wcmVt/aXVtL3ZldG9yLWRl/LXNpbmFsLWRlLW5l/b24tZGUtZXN0YWNp/b25hbWVudG8tbW9k/ZWxvLWRlLWRlc2ln/bi1kZS16b25hLWRl/LWVzdGFjaW9uYW1l/bnRvLWJhbm5lci1k/ZS1sdXotZGUtc2lu/YWwtZGUtbmVvbi1w/bGFjYS1kZS1uZW9u/LXRvZGFzLWFzLW5v/aXRlcy1pbnNjcmlj/YW8tZGUtbHV6LWRl/LXB1YmxpY2lkYWRl/LWJyaWxoYW50ZS1p/bHVzdHJhY2FvLXZl/dG9yaWFsXzU0OTg5/Ny0yMTE5LmpwZz9z/ZW10PWFpc19oeWJy/aWQ');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
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
            text-shadow: 0px 0px 6px rgba(76, 0, 255, 1), 0px 0px 6px rgba(76, 0, 255, 1);
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
          background-Color: rgba(18, 68, 3, 1);
          border: 2px solid rgba(71, 238, 107, 1);
          color: rgba(9, 255, 0, 1);
          border-radius: 10px;
          padding: 7px 7px;
          margin: 5px;
          font-size: 16px;  
          font-weight: bold;
        }

        #btnSaida{
          cursor: pointer;
          background-Color: rgba(68, 3, 3, 1);
          border: 2px solid rgba(238, 71, 71, 1);
          color: rgba(255, 0, 0, 1);
          border-radius: 10px;
          padding: 7px 7px;
          margin: 5px;
          font-size: 16px;  
          font-weight: bold;
        }

        #btnRelatorio{
          cursor: pointer;
          background-Color: rgba(68, 3, 59, 1);
          border: 2px solid rgba(238, 71, 216, 1);
          color: rgba(255, 0, 200, 1);
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