<?php


namespace App\Domain\Query;

use App\Entity\User;

/**
 * Class ListOfFavoritesQuery
 * @package App\Domain\Query
 */
class ListOfFavoritesQuery
{

    /**
     * @var User
     */
    private User $user;

    /**
     * ListOfFavoritesQuery constructor.
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