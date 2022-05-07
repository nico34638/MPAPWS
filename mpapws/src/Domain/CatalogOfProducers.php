<?php


namespace App\Domain;

use App\Domain\Query\ListOfFavoritesQuery;

/**
 * Interface CatalogOfProducers
 * @package App\Domain
 */
interface CatalogOfProducers
{
    public function allProducers(): iterable;

    /**
     * @return mixed
     */
    public function allFavorites(ListOfFavoritesQuery $query): iterable;

}