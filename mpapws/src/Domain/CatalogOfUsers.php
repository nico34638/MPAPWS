<?php


namespace App\Domain;


use App\Domain\Command\RegisterCommand;

/**
 * Interface CatalogOfUsers
 * @package App\Domain
 */
interface CatalogOfUsers
{

    /**
     * @param RegisterCommand $command
     * @return mixed
     */
    public function addUser(RegisterCommand $command);

}