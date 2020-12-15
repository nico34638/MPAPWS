<?php


namespace App\Domain\Query;


use App\Domain\CatalogueOfProducer;

class ListProducersHandler
{

    private $catalogueOfProducter;

    public function __construct(CatalogueOfProducer $catalogueOfProducter)
    {
        $this->catalogueOfProducter = $catalogueOfProducter;
    }

    public function handle(ListProducerQuery $query): iterable
    {
        return $this->catalogueOfProducter->allProducers();
    }
}