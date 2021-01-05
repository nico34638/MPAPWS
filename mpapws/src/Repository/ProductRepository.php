<?php

namespace App\Repository;

use App\Domain\CatalogOfProducts;
use App\Domain\Command\AddProductCommand;
use App\Domain\Query\SearchProductQuery;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements CatalogOfProducts
{
    /**
     * ProductRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return iterable
     */
    public function allProducts(): iterable
    {
        return $this->findAll();
    }


    /**
     * @param AddProductCommand $command
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProduct(AddProductCommand $command)
    {
        //dd($command->getProduct());
        $em =  $this->getEntityManager();
        $em->persist($command->getProduct());
        $em->flush();
    }

    /**
     * @param SearchProductQuery $query
     * @return int|mixed|string
     */
    public function searchProduct(SearchProductQuery $query)
    {
        return $this->createQueryBuilder('p')
            ->where('MATCH_AGAINST(p.name, p.description) AGAINST(:param boolean)> 0.05')
            ->setParameter('param', $query->getKeyWord())
            ->getQuery()
            ->getResult();
    }
}
