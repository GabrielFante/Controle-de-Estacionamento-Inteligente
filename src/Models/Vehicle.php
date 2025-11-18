<?php
declare(strict_types=1);

final class Vehicle
{
    private string $plate;
    private string $model;
    private string $color;

    public function __construct(string $plate, string $model, string $color)
    {
        $this->plate = $plate;
        $this->model = $model;
        $this->color = $color;
    }

    public function getPlate(): string
    {
        return $this->plate;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}