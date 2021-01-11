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