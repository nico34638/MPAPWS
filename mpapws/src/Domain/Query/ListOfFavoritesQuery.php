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
     * ListOfFavoritesQuery constructor.
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