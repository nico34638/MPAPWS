<?php


namespace App\Domain;

use App\Domain\Command\ContactFormCommand;

/**
 * Interface CatalogOfMessages
 * @package App\Domain
 */
interface CatalogOfMessages
{
    /**
     * @param ContactFormCommand $command
     * @return mixed
     */
    public function addUser(ContactFormCommand $command);
}