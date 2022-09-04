<?php

namespace App\Entity;

use App\Repository\TenderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TenderRepository::class)
 */
class Tender
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $external_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $change_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalCode(): ?int
    {
        return $this->external_code;
    }

    public function setExternalCode(int $external_code): self
    {
        $this->external_code = $external_code;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getChangeTime(): ?\DateTimeInterface
    {
        return $this->change_time;
    }

    public function setChangeTime(\DateTimeInterface $change_time): self
    {
        $this->change_time = $change_time;

        return $this;
    }
}
