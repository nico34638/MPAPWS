<?php


namespace App\Domain;


use App\Domain\Command\AddFollowingCommand;
use App\Domain\Command\DeleteFollowingCommand;
use App\Domain\Command\RegisterCommand;

/**
 * Interface CatalogOfUsers
 * @package App\Domain
 */
interface CatalogOfUsers
{

    /**
     * @return mixed
     */
    public function addUser(RegisterCommand $command);


    /**
     * @return mixed
     */
    public function addFollowing(AddFollowingCommand $command);

    /**
     * @param AddFollowingCommand $command
     * @return mixed
     */
    public function deleteFollowing(DeleteFollowingCommand $command);
}