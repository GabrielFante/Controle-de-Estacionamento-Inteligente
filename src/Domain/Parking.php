<?php
declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;

final class Parking
{
    public function __construct(
        private string $plate,
        private string $vehicleType,
        private DateTimeImmutable $entryTime,
        private ?DateTimeImmutable $exitTime = null,
        private ?float $hours = null,
        private ?float $price = null,
        private ?int $id = null
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getPlate(): string { return $this->plate; }
    public function getVehicleType(): string { return $this->vehicleType; }
    public function getEntryTime(): DateTimeImmutable { return $this->entryTime; }
    public function getExitTime(): ?DateTimeImmutable { return $this->exitTime; }
    public function getHours(): ?float { return $this->hours; }
    public function getPrice(): ?float { return $this->price; }

    public function withExit(DateTimeImmutable $exitTime, float $price, float $hours): self
    {
        return new self($this->plate, $this->vehicleType, $this->entryTime, $exitTime, $hours, $price, $this->id);
    }
}