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
     * @var CatalogOfProducers
     */
    private CatalogOfProducers $catalogOfProducers;

    /**
     * ListOfFavoritesHandler constructor.
     * @param CatalogOfProducers $catalogOfProducers
     */
    public function __construct(CatalogOfProducers $catalogOfProducers)
    {
        $this->catalogOfProducers = $catalogOfProducers;
    }

    /**
     * @param ListOfFavoritesQuery $query
     */
    public function handle(ListOfFavoritesQuery $query): iterable
    {
        return $this->catalogOfProducers->allFavorites($query);
    }


}