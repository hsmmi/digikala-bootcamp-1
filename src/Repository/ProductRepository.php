<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByIds(array $ids): array // [1, 5, 10]
    {
        // SELECT * FROM product WHERE id IN (1, 5, 10)
        // query builder: generate a query
        $qb = $this->createQueryBuilder('p'); // p is a shortcut for Product
        // $qb->where($qb->expr()->in('p.id', $ids)); // not secure
        $q = $qb
            ->where('p.id IN (:ids)') // where p.id IN (:ids)
            ->setParameter('ids', $ids) // setParameter('ids', [1, 5, 10])
            ->getQuery() // getQuery() returns a Query object
            ->getResult() // getResult() returns an array of Product objects
        ;
        // read doctrine documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html#query-builder-methods

        // dd($q);

        return $q;
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
