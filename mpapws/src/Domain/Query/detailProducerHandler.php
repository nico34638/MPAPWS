<?php


namespace App\Domain\Query;


use App\Domain\CatalogOfProducers;

class detailProducerHandler
{

    private $catalog;

    public function __construct(CatalogOfProducers $aCatalogOfProducer)
    {
        $this->catalog = $aCatalogOfProducer;
    }

    public function handle(detailProducerQuery $query, $username)
    {
        return $this->catalog->findOneBy(['username' => $username]);
    }
}