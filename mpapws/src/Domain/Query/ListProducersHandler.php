<?php


namespace App\Domain\Query;


use App\Domain\CatalogOfProducers;

class ListProducersHandler
{

    private $catalog;

    public function __construct(CatalogOfProducers $aCatalogOfProducer)
    {
        $this->catalog = $aCatalogOfProducer;
    }

    public function handle(ListProducersQuery $query): iterable
    {
        return $this->catalog->allProducers();
    }
}