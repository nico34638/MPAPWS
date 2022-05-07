<?php


namespace App\Domain\Command;


use App\Domain\CatalogOfUsers;

class AddFollowingHandler
{
    /**
     * AddFollowingHandler constructor.
     * @param CatalogOfUsers $catalogOfUsers
     */
    public function __construct(private CatalogOfUsers $catalogOfUsers)
    {
    }

    public function handle(AddFollowingCommand $command)
    {
        $this->catalogOfUsers->addFollowing($command);
    }


}