<?php

namespace App\Repository;

use App\Entity\Tender;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Tender>
 *
 * @method Tender|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tender|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tender[]    findAll()
 * @method Tender[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TenderRepository extends ServiceEntityRepository
{
    protected EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tender::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Tender $entity, bool $flush = false): void
    {
        $this->em->persist($entity);

        if ($flush) {
            $this->em->flush();
        }
    }

    public function remove(Tender $entity, bool $flush = false): void
    {
        $this->em->remove($entity);

        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @param array $params
     *
     * @return array|null
     * @throws \Exception
     */
    public function findByParams(array $params): ?array
    {
        $tenders = $this->createQueryBuilder('t');

        if (isset($params["name"])) {
            $tenders->andWhere($tenders->expr()->like('t.name', ':name'))
                ->setParameter("name", "%".$params["name"]."%");
        }

        if (isset($params["date"])) {
            $date = new \DateTimeImmutable($params["date"]);

            $tenders->andWhere('t.change_time >= :date_start')
                ->andWhere('t.change_time <= :date_end')
                ->setParameter('date_start', $date->format('Y-m-d 00:00:00'))
                ->setParameter('date_end',   $date->format('Y-m-d 23:59:59'));
        }

        return $tenders->getQuery()->getResult();
    }

    public function findById(int $id): ?Tender
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Tender[] Returns an array of Tender objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tender
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
