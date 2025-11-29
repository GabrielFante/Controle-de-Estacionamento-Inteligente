<?php
declare(strict_types=1);

namespace App\Domain;

final class Parking
{
    public function __construct(
        private ?int $id = 1,
        private string $plate,
        private string $vehicleType,
        private \DateTimeImmutable $entryTime,
        private ?\DateTimeImmutable $exitTime = null
    ) {
        $this->id = $id;
        $this->plate = $plate;
        $this->vehicleType = $vehicleType;
        $this->entryTime = $entryTime;
        $this->exitTime = $exitTime;
    }

    public function nextId(): int
    {
        return $this->id + 1;
    }

    public function getId(): ?int { return $this->id; }

    public function getPlate(): string { return $this->plate; }

    public function getVehicleType(): string { return $this->vehicleType;}

    public function getEntryTime(): \DateTimeImmutable { return $this->entryTime; }

    public function getExitTime(): ?\DateTimeImmutable { return $this->exitTime; }

    public function withId(int $id): self
    {
        return new self($id, $this->plate, $this->vehicleType, $this->entryTime, $this->exitTime);
    }
}