<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\LocationRecherche ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @return Query
     */
    public function findAllVisibleQuery(LocationRecherche $recherche): Query
    {
        $query = $this->findVisibleQuery();

        if ($recherche->getPrixMax())
        {
            $query = $query
            ->andWhere('l.prix <= :prixmax')
            ->setParameter('prixmax', $recherche->getPrixMax());
        }

        if ($recherche->getSurfaceMin())
        {
            $query = $query
            ->andWhere('l.surface >= :surfacemin')
            ->setParameter('surfacemin', $recherche->getSurfaceMin());
        }

        if ($recherche->getOptions()->count() > 0)
        {
            $k = 0;
            foreach($recherche->getOptions() as $k => $option)
            {
                $k++;
                $query = $query
                    ->andWhere(":option$k MEMBER OF l.options")
                    ->setParameter("option$k", $option);
            }
        }
        return $query->getQuery();
    }

    /**
     * @return Location[]
     */
    public function findLastest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    private function findVisibleQuery (): QueryBuilder
    {
        return $this->createQueryBuilder('l')
            ->Where('l.louer = false');
    }

    // /**
    //  * @return Location[] Returns an array of Location objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Location
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
