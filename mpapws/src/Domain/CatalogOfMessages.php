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
    public function allMessages(): iterable;


    public function __construct(ManagerRegistry $registry);

    /**
     * @return mixed
     */
    public function addMessage(ContactFormCommand $command);
}