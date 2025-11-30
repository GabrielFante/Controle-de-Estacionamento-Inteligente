## Controle de Estacionamento Inteligente

Sistema web simples para registrar entrada, saída e gerar relatórios de um estacionamento, aplicando e praticando os principios de SOLID em php.
A cobrança é feita por hora, arredondando sempre para cima, e os preços vêm diretamente de classes por tipo de veículo:

Veículo	Valor / hora
Moto	R$ 3
Carro	R$ 5
Caminhão	R$ 10

## Requisitos:
- PHP 8+
- composer
- sqlite3 (Já embutido)
- Servidor embutido do PHP
  
## Participantes
- Gabriel Fante Javarotti -- 1990554
- Miguel Guarnetti -- 1999154

## Objetivo do projeto

Automatizar o cálculo de uso do estacionamento e fornecer:

✅ Registro de entrada de veículos pela placa
✅ Registro de saída + cálculo de horas e valor total
✅ Relatórios completos com:
  • Quantidade de veículos por tipo
  • Total de horas estacionadas
  • Faturamento por categoria
  • Faturamento geral

O sistema usa Composer para autoload e SQLite como banco.

📁 Estrutura de pastas
```
    /Controle-de-Estacionamento-Inteligente
    │── /public -> Telas de Visualização(Front-End)
    │    │── index.php
    │    │── entry.php
    │    │── exit.php
    │    │── report.php
    │── /src
    │    │── /Application -> Orquestra as entradas e Saídas
    │    │      │── ParkingService.php
    │    │── /Domain -> Regras de Negócio
    │    │      │── Parking.php
    │    │      │── ParkingValidator.php
    │    │      │── ParkingCalculator.php
    │    │      │── ParkingRepository.php (interface)
    │    │── /Domain/VehicleHourPrice
    │    │      │── CarPrice.php
    │    │      │── MotorcyclePrice.php
    │    │      │── TruckPrice.php
    │    │      │── IPrice.php (interface)
    │── /storage -> DataBase
    │    │── database.sqlite
    │── /vendor (gerado pelo composer)
    │── composer.json
    │── migrate.php
```

## Comandos para rodar o projeto
1º Clone o repositório:
```git clone https://github.com/GabrielFante/Controle-de-Estacionamento-Inteligente.git```

2º Rode a pasta do projeto:
```cd Controle-de-Estacionamento-Inteligente```

1º Instalar dependências do Composer na pasta do projeto
```composer install```

2º Criar/Recriar a tabela do banco SQLite
```php migrate.php```

3º Acessar no navegador
localhost/Controle-de-Estacionamento-Inteligente/public/index.php

## Como funciona

O Front-end envia a placa e o tipo de veículo

A ParkingService orquestra a operação

A ParkingCalculator calcula horas e preço total

O Repository salva no SQLite

O relatório soma apenas veículos que já tem preço calculado no banco

## Decisões da dupla nos princípios SOLID:

ParkingValidator -> cuida apenas da validação dos dados, especialmente da placa.

ParkingCalculator -> responsável por calcular horas e valor total, arredondando as horas sempre para cima.

IPrice → interface implementada pelas classes de preço (CarPrice, TruckPrice, MotorcyclePrice), onde cada uma retorna seu valor por hora.

SqliteParkingRepository → implementa ParkingRepository e faz exclusivamente a comunicação com o banco SQLite via PDO.

ParkingService -> atua somente como orquestrador, chamando a validação, cálculo e persistência. Ele não contém regras fixas de cálculo nem lógica de preço.

O sistema opera pela placa do veículo, não dependendo de id, garantindo desacoplamento e clareza no fluxo.

Princípios respeitados

- SRP —> cada classe tem 1 responsabilidade clara
- OCP —> novos veículos podem ser adicionados criando novas classes de preço, sem alterar a service
- DIP e ISP —> uso de interfaces reais para desacoplamento

## Resultado esperado

# Registro de Entrada:
![Tela Entrada](images/RegistroDeEntrada.png)

# Registro de Saída:
![Tela Entrada](images/RegistroDeSaida.png)

Relatório principal (listagem abaixo do botão Registrar Saída) mostra:
Total veículos: 6 - 7

Faturamento Moto: R$ 3 - 6

Faturamento Carro: R$ 40

Faturamento Caminhão: R$ 20

Total Faturado: R$ 63~66

Saída exibe:
abc1234 — 2h — R$ 10

abc1234 — 2h — R$ 20


(ativo aparece apenas como — ativo, sem horas nem valor)
