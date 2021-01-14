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
     * @var User
     */
    private User $currentUser;

    /**
     * @var User
     */
    private User $producer;

    /**
     * AddFollowingCommand constructor.
     * @param User $currentUser
     * @param User $producer
     */
    public function __construct(User $currentUser, User $producer)
    {
        $this->currentUser = $currentUser;
        $this->producer = $producer;
    }

    /**
     * @return User
     */
    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }

    /**
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }
}