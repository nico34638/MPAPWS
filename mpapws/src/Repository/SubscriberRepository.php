<?php

namespace App\Repository;

use App\Domain\CatalogOfSubscribers;
use App\Domain\Command\AddSubscriberCommand;
use App\Domain\Command\DeleteSubscriberCommand;
use App\Entity\Subscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subscriber|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscriber|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscriber[]    findAll()
 * @method Subscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberRepository extends ServiceEntityRepository implements CatalogOfSubscribers
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscriber::class);
    }

    // /**
    //  * @return Subscriber[] Returns an array of Subscriber objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subscriber
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function addSubscriber(AddSubscriberCommand $command)
    {
        $em =  $this->getEntityManager();
        $em->persist($command->getSubscriber());
        $em->flush();
    }

    public function allSubscribers(): iterable
    {
        return $this->findAll();
    }

    public function deleteSubscriber(DeleteSubscriberCommand $command)
    {
        $em = $this->getEntityManager();
        $em->remove($command->getSubscriber());
        $em->flush();
    }

    public function findByCode($code)
    {
        $subs = $this->findAll();
        foreach ($subs as &$sub){
            if($code==hash('md5',$sub->getEmail()))
            {
                echo ''.$sub->getEmail();
                return $sub;
            }
        }
    }
}
