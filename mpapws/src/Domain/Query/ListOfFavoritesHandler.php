<?php


namespace App\Domain\Query;

use App\Domain\CatalogOfProducers;

/**
 * Class ListOfFavoritesHandler
 * @package App\Domain\Query
 */
class ListOfFavoritesHandler
{

    /**
     * ListOfFavoritesHandler constructor.
     * @param CatalogOfProducers $catalogOfProducers
     */
    public function __construct(private CatalogOfProducers $catalogOfProducers)
    {
    }

    public function handle(ListOfFavoritesQuery $query): iterable
    {
        return $this->catalogOfProducers->allFavorites($query);
    }


}