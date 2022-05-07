<?php


namespace App\Domain\Query;


use App\Domain\CatalogOfProducers;

class ListProducersHandler
{

    public function __construct(private CatalogOfProducers $catalog)
    {
    }

    public function handle(ListProducersQuery $query): iterable
    {
        return $this->catalog->allProducers();
    }
}