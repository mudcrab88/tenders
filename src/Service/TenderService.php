<?php

namespace App\Service;

use App\Entity\Tender;
use App\Repository\TenderRepository;
use App\DataTransferObject\TenderDTO;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TenderService
{
    protected TenderRepository $repository;

    protected ObjectManager $entityManager;

    public function __construct(TenderRepository $repository, ManagerRegistry $doctrine)
    {
        $this->repository = $repository;
        $this->entityManager = $doctrine->getManager();
    }

    /**
     * @param TenderDTO $dto
     */
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

    /**
     * @param array $params
     *
     * @return array
     */
    public function getByParams(array $params): array
    {
        $tenders = $this->repository->findByParams($params);

        if (empty($tenders)) {
            throw new NotFoundHttpException("По заданным параметрам тендеров не найдено.");
        }

        $tendersArray = [];
        foreach ($tenders as $tender) {
            $tendersArray[] = TenderDto::fromEntity($tender);
        }

        return $tendersArray;
    }

    /**
     * @param int $id
     *
     * @return TenderDTO|null
     */
    public function getById(int $id): ?TenderDTO
    {
        $tender = $this->repository->findById($id);

        if (empty($tender)) {
            throw new NotFoundHttpException("Тендер не найден.");
        }

        return TenderDto::fromEntity($tender);
    }
}
