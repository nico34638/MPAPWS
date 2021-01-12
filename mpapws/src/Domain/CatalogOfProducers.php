<?php


namespace App\Domain;

use App\Domain\Query\ListOfFavoritesQuery;

/**
 * Interface CatalogOfProducers
 * @package App\Domain
 */
interface CatalogOfProducers
{
    /**
     * @return iterable
     */
    public function allProducers(): iterable;

    /**
     * @param ListOfFavoritesQuery $query
     * @return mixed
     */
    public function allFavorites(ListOfFavoritesQuery $query): iterable;

}