<?php

namespace App\Repository;

use App\Domain\CatalogOfMessages;
use App\Domain\Command\ContactFormCommand;
use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository implements CatalogOfMessages
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function allMessages(): iterable
    {
        return $this->findAll();
    }

    /**
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addMessage(ContactFormCommand $command)
    {
        $em =  $this->getEntityManager();
        $em->persist($command->getMessage());
        $em->flush();
    }
}
