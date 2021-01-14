<?php


namespace App\Domain\Command;


use App\Domain\CatalogOfUsers;

class AddFollowingHandler
{
    private CatalogOfUsers $catalogOfUsers;

    /**
     * AddFollowingHandler constructor.
     * @param CatalogOfUsers $catalogOfUsers
     */
    public function __construct(CatalogOfUsers $catalogOfUsers)
    {
        $this->catalogOfUsers = $catalogOfUsers;
    }

    public function handle(AddFollowingCommand $command)
    {
        $this->catalogOfUsers->addFollowing($command);
    }


}