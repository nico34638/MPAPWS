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
     * RegisterCommand constructor.
     * @param User $user
     */
    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }




}