<?php

namespace App\DataTransferObject;

class TenderDTO
{
    public ?int $id;

    public int $external_code;

    public string $number;

    public ?string $status;

    public string $name;

    public \DateTimeInterface $change_time;

    /**
     * @throws \Exception
     */
    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->external_code = (int)$data[0];
        $dto->number = $data[1];
        $dto->status = $data[2];
        $dto->name = $data[3];
        $dto->change_time = new \DateTimeImmutable($data[4]);

        return $dto;
    }
}
