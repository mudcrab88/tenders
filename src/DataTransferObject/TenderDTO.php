<?php

namespace App\DataTransferObject;

use App\Entity\Tender;

class TenderDTO implements \JsonSerializable
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

    public static function fromEntity(Tender $tender): self
    {
        $dto = new self();

        $dto->id = $tender->getId();
        $dto->external_code = $tender->getExternalCode();
        $dto->number = $tender->getNumber();
        $dto->status = $tender->getStatus();
        $dto->name = $tender->getName();
        $dto->change_time = $tender->getChangeTime();

        return $dto;
    }

    public static function fromJsonDecoded(array $data): self
    {
        $dto = new self();

        $dto->external_code = $data["external_code"];
        $dto->number =  $data["number"];
        $dto->status =  $data["status"];
        $dto->name =  $data["name"];
        $dto->change_time = new \DateTimeImmutable();

        return $dto;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" =>  $this->id,
            "external_code" => $this->external_code,
            "number" => $this->number,
            "status" => $this->status,
            "name" => $this->name,
            "change_time" => $this->change_time->format("Y-m-d H:i:s")
        ];
    }
}
