<?php


namespace App\Domain\Command;


use App\Domain\CatalogOfUsers;

/**
 * Class RegisterHandler
 * @package App\Domain\Command
 */
class RegisterHandler
{
    /**
     * RegisterHandler constructor.
     * @param CatalogOfUsers $catalogOfUsers
     */
    public function __construct(private CatalogOfUsers $catalogOfUsers)
    {
    }

    public function handle(RegisterCommand $command)
    {
        $this->catalogOfUsers->addUser($command);
    }


}