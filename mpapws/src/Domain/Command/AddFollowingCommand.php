<?php


namespace App\Domain\Command;


use App\Entity\User;

/**
 * Class AddFollowingCommand
 * @package App\Domain\Command
 */
class AddFollowingCommand
{
    /**
     * AddFollowingCommand constructor.
     * @param User $currentUser
     * @param User $producer
     */
    public function __construct(private User $currentUser, private User $producer)
    {
    }

    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }

    public function getProducer(): User
    {
        return $this->producer;
    }


}