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
     * @var CatalogOfUsers
     */
    private CatalogOfUsers $catalogOfUsers;

    /**
     * RegisterHandler constructor.
     * @param CatalogOfUsers $catalogOfUsers
     */
    public function __construct(CatalogOfUsers $catalogOfUsers)
    {
        $this->catalogOfUsers = $catalogOfUsers;
    }

    public function handle(RegisterCommand $command)
    {
        $this->catalogOfUsers->addUser($command);
    }


}