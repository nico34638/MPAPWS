<?php


namespace App\Domain;

use App\Domain\Command\ContactFormCommand;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Interface CatalogOfMessages
 * @package App\Domain
 */
interface CatalogOfMessages
{
    /**
     * @return iterable
     */
    public function allMessages(): iterable;


    public function __construct(ManagerRegistry $registry);

    /**
     * @param ContactFormCommand $command
     * @return mixed
     */
    public function addMessage(ContactFormCommand $command);
}