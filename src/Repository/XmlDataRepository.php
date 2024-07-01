<?php

namespace App\Repository;

use App\Entity\XmlData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XmlData>
 */
class XmlDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XmlData::class);
    }

    public function getEntityIds(): array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.entity_id')
        ;

        $query = $qb->getQuery();

        return array_column($query->getArrayResult(), 'entity_id');
    }

    public function truncateEntries(): void
    {
        $qb = $this->createQueryBuilder('e')
            ->delete()
        ;

        $qb->getQuery()->execute();
    }
}
