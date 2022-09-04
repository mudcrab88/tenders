<?php

namespace App\Service;

use App\Entity\Tender;
use App\Repository\TenderRepository;
use App\DataTransferObject\TenderDTO;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class TenderService
{
    protected TenderRepository $repository;

    protected ObjectManager $entityManager;

    public function __construct(TenderRepository $repository, ManagerRegistry $doctrine)
    {
        $this->repository = $repository;
        $this->entityManager = $doctrine->getManager();
    }

    public function createFromDto(TenderDTO $dto): void
    {
        $tender = new Tender();

        $tender->setExternalCode($dto->external_code);
        $tender->setNumber($dto->number);
        $tender->setStatus($dto->status);
        $tender->setName($dto->name);
        $tender->setChangeTime($dto->change_time);

        $this->repository->add($tender, true);
    }

    public function getByParams(array $params): array
    {
        $tenders = $this->repository->findByParams($params);

        return $tenders;
    }
}
