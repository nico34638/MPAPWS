<?php


namespace App\Domain\Command;


use App\Entity\User;

/**
 * Class DeleteFollowingCommand
 * @package App\Domain\Command
 */
class DeleteFollowingCommand
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