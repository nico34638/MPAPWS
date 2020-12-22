<?php


namespace App\Domain\Command;

use App\Entity\User;

/**
 * Class RegisterCommand
 * @package App\Domain\Command
 */
class RegisterCommand
{
    /**
     * @var User
     */
    private User $user;

    /**
     * RegisterCommand constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }




}