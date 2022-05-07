<?php

namespace App\Repository;

use App\Domain\CatalogOfProducts;
use App\Domain\Command\AddProductCommand;
use App\Domain\Command\DeleteProductCommand;
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

    public function allProducts(): iterable
    {
        return $this->findAll();
    }


    /**
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

    public function deleteProduct(DeleteProductCommand $command)
    {
        $em =  $this->getEntityManager();
        $em->remove($command->getProduct());
        $em->flush();
    }
}
