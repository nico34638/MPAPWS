<?php


namespace App\Domain\Command;

use App\Domain\CatalogOfUsers;

/**
 * Class DeleteFollowingHandler
 * @package App\Domain\Command
 */
class DeleteFollowingHandler
{

    /**
     * AddFollowingHandler constructor.
     * @param CatalogOfUsers $catalogOfUsers
     */
    public function __construct(private CatalogOfUsers $catalogOfUsers)
    {
    }

    public function handle(DeleteFollowingCommand $command)
    {
        $this->catalogOfUsers->deleteFollowing($command);
    }

}