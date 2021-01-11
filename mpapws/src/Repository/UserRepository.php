<?php

namespace App\Repository;

use App\Domain\CatalogOfProducers;
use App\Domain\CatalogOfUsers;
use App\Domain\Command\AddFollowingCommand;
use App\Domain\Command\RegisterCommand;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements CatalogOfProducers, CatalogOfUsers
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $email
     * @return int|null
     */
    public function getUserByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :e')
            ->setParameter('e', $email)
            ->getQuery()
            ->getFirstResult();
    }

    /**
     * @return iterable
     */
    public function allProducers(): iterable
    {
        return $this->createQueryBuilder('u')
            ->select('u.firstName, u.lastName, u.email, u.roles, u.address, u.username')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_PRODUCER%')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param RegisterCommand $command
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addUser(RegisterCommand $command)
    {
        $em =  $this->getEntityManager();
        $em->persist($command->getUser());
        $em->flush();
    }

    /**
     * @param AddFollowingCommand $command
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addFollowing(AddFollowingCommand $command)
    {
        $currentUser = $command->getCurrentUser();
        $producer = $command->getProducer();

        $currentUser->addFollowing($producer);

        $em =  $this->getEntityManager();

        $em->persist($currentUser);
        $em->flush();
    }
}
