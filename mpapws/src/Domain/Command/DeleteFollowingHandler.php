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
     * @var CatalogOfUsers
     */
    private CatalogOfUsers $catalogOfUsers;

    /**
     * AddFollowingHandler constructor.
     * @param CatalogOfUsers $catalogOfUsers
     */
    public function __construct(CatalogOfUsers $catalogOfUsers)
    {
        $this->catalogOfUsers = $catalogOfUsers;
    }

    public function handle(DeleteFollowingCommand $command)
    {
        $this->catalogOfUsers->deleteFollowing($command);
    }

}